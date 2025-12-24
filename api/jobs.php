<?php
header('Content-Type: application/json');
require_once '../includes/auth.php';
require_once '../config/database.php';

$auth = new Auth();
$db = new Database();

$method = $_SERVER['REQUEST_METHOD'];

// Check authentication for protected endpoints
function requireAuth() {
    global $auth;
    if (!$auth->isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['error' => 'Authentication required']);
        exit();
    }
}

switch ($method) {
    case 'GET':
        // Get jobs with filters
        $filters = [
            'status' => $_GET['status'] ?? 'active',
            'category' => $_GET['category'] ?? '',
            'location' => $_GET['location'] ?? '',
            'type' => $_GET['type'] ?? '',
            'page' => $_GET['page'] ?? 1,
            'limit' => $_GET['limit'] ?? 10
        ];
        
        // In a real implementation, you would query Firebase with these filters
        // For now, return mock data
        echo json_encode([
            'success' => true,
            'jobs' => [],
            'total' => 0,
            'page' => $filters['page'],
            'limit' => $filters['limit']
        ]);
        break;
        
    case 'POST':
        requireAuth();
        
        // Create new job (for recruiters only)
        if ($auth->getUserRole() !== 'recruiter') {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            break;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validate required fields
        $required = ['title', 'company', 'location', 'job_type', 'description'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                http_response_code(400);
                echo json_encode(['error' => "Missing required field: $field"]);
                exit();
            }
        }
        
        // Add metadata
        $data['recruiter_id'] = $auth->getUserId();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['status'] = $data['status'] ?? 'active';
        
        // Save to Firebase
        $result = $db->pushData('jobs', $data);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Job created successfully',
                'job_id' => $result->getKey()
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create job']);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>