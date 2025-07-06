<?php
include '../includes/header.php';
require_once '../includes/db.php';
require_once '../includes/audit.php';

// Get filter parameters
$action_filter = $_GET['action'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 50;
$offset = ($page - 1) * $limit;

// Build filters
$filters = [];
if ($action_filter) $filters['action'] = $action_filter;
if ($date_from) $filters['date_from'] = $date_from;
if ($date_to) $filters['date_to'] = $date_to;

// Get audit logs
$logs = getAuditLogs($pdo, $filters, $limit, $offset);
$actions = getAuditActions($pdo);

// Get total count for pagination
$count_filters = $filters;
$count_query = "SELECT COUNT(*) FROM audit_logs al";
if (!empty($count_filters)) {
    $where_conditions = [];
    $params = [];
    if (!empty($count_filters['action'])) {
        $where_conditions[] = "action = ?";
        $params[] = $count_filters['action'];
    }
    if (!empty($count_filters['date_from'])) {
        $where_conditions[] = "created_at >= ?";
        $params[] = $count_filters['date_from'];
    }
    if (!empty($count_filters['date_to'])) {
        $where_conditions[] = "created_at <= ?";
        $params[] = $count_filters['date_to'];
    }
    if (!empty($where_conditions)) {
        $count_query .= " WHERE " . implode(" AND ", $where_conditions);
    }
    $stmt = $pdo->prepare($count_query);
    $stmt->execute($params);
} else {
    $stmt = $pdo->query($count_query);
}
$total_records = $stmt->fetchColumn();
$total_pages = ceil($total_records / $limit);
?>

<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
</div>

<div class="container py-5">
    <h2 class="mb-4 text-primary">Audit Logs</h2>
    
    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filters</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Action</label>
                    <select name="action" class="form-select">
                        <option value="">All Actions</option>
                        <?php foreach ($actions as $action): ?>
                            <option value="<?php echo htmlspecialchars($action); ?>" 
                                    <?php if ($action_filter === $action) echo 'selected'; ?>>
                                <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $action))); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="<?php echo htmlspecialchars($date_from); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="<?php echo htmlspecialchars($date_to); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="audit_logs.php" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Results -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Audit Log Entries</h5>
            <span class="badge bg-secondary"><?php echo $total_records; ?> total records</span>
        </div>
        <div class="card-body">
            <?php if (empty($logs)): ?>
                <p class="text-muted">No audit logs found matching your criteria.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Date/Time</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>User</th>
                                <th>IP Address</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo date('M j, Y g:i A', strtotime($log['created_at'])); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $log['action']))); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($log['description']); ?></td>
                                    <td>
                                        <?php if ($log['username']): ?>
                                            <span class="text-primary"><?php echo htmlspecialchars($log['username']); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">Unknown</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo htmlspecialchars($log['ip_address']); ?></small>
                                    </td>
                                    <td>
                                        <?php if ($log['details']): ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                    onclick="showDetails('<?php echo htmlspecialchars(addslashes($log['details'])); ?>')">
                                                View
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Audit logs pagination">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Action Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="detailsContent" class="bg-light p-3 rounded"></pre>
            </div>
        </div>
    </div>
</div>

<script>
function showDetails(details) {
    try {
        const parsed = JSON.parse(details);
        document.getElementById('detailsContent').textContent = JSON.stringify(parsed, null, 2);
    } catch (e) {
        document.getElementById('detailsContent').textContent = details;
    }
    new bootstrap.Modal(document.getElementById('detailsModal')).show();
}
</script>

<?php include '../includes/footer.php'; ?> 