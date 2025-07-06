<?php
/**
 * Audit Logging Utility Functions
 * Logs important admin actions for accountability and tracking
 */

/**
 * Log an admin action to the audit_logs table
 * 
 * @param PDO $pdo Database connection
 * @param string $action The action performed (e.g., 'promote_students', 'edit_student')
 * @param string $description Human-readable description of the action
 * @param array $details Additional details as JSON (optional)
 * @param int $user_id Admin user ID (optional, defaults to session user)
 * @return bool Success status
 */
function logAuditAction($pdo, $action, $description, $details = null, $user_id = null) {
    try {
        // Get user ID from session if not provided
        if (!$user_id && isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }
        
        // Prepare the audit log entry
        $stmt = $pdo->prepare("
            INSERT INTO audit_logs (action, description, details, user_id, ip_address, user_agent, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $details_json = $details ? json_encode($details) : null;
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        return $stmt->execute([
            $action,
            $description,
            $details_json,
            $user_id,
            $ip_address,
            $user_agent
        ]);
    } catch (Exception $e) {
        // Log error but don't break the main functionality
        error_log("Audit logging failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Get audit logs with optional filtering
 * 
 * @param PDO $pdo Database connection
 * @param array $filters Optional filters (action, user_id, date_from, date_to)
 * @param int $limit Number of records to return
 * @param int $offset Offset for pagination
 * @return array Audit log records
 */
function getAuditLogs($pdo, $filters = [], $limit = 50, $offset = 0) {
    $where_conditions = [];
    $params = [];
    
    if (!empty($filters['action'])) {
        $where_conditions[] = "action = ?";
        $params[] = $filters['action'];
    }
    
    if (!empty($filters['user_id'])) {
        $where_conditions[] = "user_id = ?";
        $params[] = $filters['user_id'];
    }
    
    if (!empty($filters['date_from'])) {
        $where_conditions[] = "created_at >= ?";
        $params[] = $filters['date_from'];
    }
    
    if (!empty($filters['date_to'])) {
        $where_conditions[] = "created_at <= ?";
        $params[] = $filters['date_to'];
    }
    
    $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
    
    $query = "
        SELECT al.*, u.username 
        FROM audit_logs al 
        LEFT JOIN users u ON al.user_id = u.id 
        $where_clause 
        ORDER BY al.created_at DESC 
        LIMIT ? OFFSET ?
    ";
    
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Get available audit actions for filtering
 * 
 * @param PDO $pdo Database connection
 * @return array List of unique actions
 */
function getAuditActions($pdo) {
    $stmt = $pdo->query("SELECT DISTINCT action FROM audit_logs ORDER BY action");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?> 