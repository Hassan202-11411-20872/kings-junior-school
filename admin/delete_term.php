<?php
include '../includes/header.php';
require_once '../includes/db.php';

$id = $_GET['id'] ?? 0;

if ($id) {
    // Check if term exists
    $stmt = $pdo->prepare('SELECT * FROM terms WHERE id = ?');
    $stmt->execute([$id]);
    $term = $stmt->fetch();
    
    if ($term) {
        // Check if there are marks associated with this term
        $stmt = $pdo->prepare('SELECT COUNT(*) as count FROM marks WHERE term_id = ?');
        $stmt->execute([$id]);
        $marks_count = $stmt->fetch()['count'];
        
        if ($marks_count > 0) {
            echo '<div class="alert alert-danger">Cannot delete this term because there are ' . $marks_count . ' marks associated with it. Please delete the marks first.</div>';
        } else {
            // Delete the term
            $stmt = $pdo->prepare('DELETE FROM terms WHERE id = ?');
            $stmt->execute([$id]);
            echo '<div class="alert alert-success">Term deleted successfully!</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Term not found.</div>';
    }
}

// Redirect back to terms page after a short delay
header('Refresh: 2; URL=terms.php');
?>
<div class="no-print my-3">
    <a href="terms.php" class="btn btn-secondary">&larr; Back to Terms</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Delete Term</h2>
    <p>Redirecting back to terms page...</p>
</div>
<?php include '../includes/footer.php'; ?> 