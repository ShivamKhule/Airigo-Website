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
    
    $existingApplication = $db->getApplication($jobId, $userEmail);
    if ($existingApplication) {
        echo json_encode(['success' => false, 'message' => 'You have already applied for this job']);
        exit;
    }
    
    $job = $db->getJobById($jobId);
    if (!$job) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Job not found']);
        exit;
    }
    
    $applicationData = [
        'jobId' => $jobId,
        'jobseekerEmail' => $userEmail,
        'status' => 'applied',
        'appliedAt' => new DateTime(),
        'jobTitle' => $job['designation'],
        'companyName' => $job['companyName']
    ];
    
    $result = $db->createApplication($jobId, $userEmail, $applicationData);
    
    if ($result) {
        logActivity($_SESSION['user_id'], 'job_application', ['job_id' => $jobId, 'job_title' => $job['designation']]);
        echo json_encode(['success' => true, 'message' => 'Application submitted successfully']);
    } else {
        throw new Exception('Failed to submit application');
    }
    
} catch (Exception $e) {
    logError("Job application error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'An error occurred while submitting your application']);
}
?>