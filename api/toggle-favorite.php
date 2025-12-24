<?php
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/firestore-db.php';

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Authentication required']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['csrf_token']) || !validateCSRFToken($input['csrf_token'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}

$jobId = $input['job_id'] ?? null;
if (!$jobId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Job ID is required']);
    exit;
}

try {
    $db = new FirestoreDB();
    $userEmail = $_SESSION['user_email'];
    
    $favorited = $db->toggleFavorite($jobId, $userEmail);
    
    logActivity($_SESSION['user_id'], $favorited ? 'favorite_job' : 'unfavorite_job', ['job_id' => $jobId]);
    
    echo json_encode([
        'success' => true,
        'favorited' => $favorited,
        'message' => $favorited ? 'Added to favorites' : 'Removed from favorites'
    ]);
    
} catch (Exception $e) {
    logError("Toggle favorite error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
}
?>