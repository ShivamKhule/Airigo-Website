<?php
session_start();
require_once __DIR__ . '/../config/firestore-db.php';

class Auth {
    private $db;
    
    public function __construct() {
        $this->db = new FirestoreDB();
    }
    
    public function register($email, $password, $userData) {
        try {
            // Check if user already exists
            $existingJobseeker = $this->db->getJobseekerByEmail($email);
            $existingRecruiter = $this->db->getRecruiterByEmail($email);
            
            if ($existingJobseeker || $existingRecruiter) {
                return ['success' => false, 'error' => 'User already exists with this email'];
            }
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Prepare user data
            $userData['email'] = $email;
            $userData['password'] = $hashedPassword;
            $userData['createdAt'] = new DateTime();
            $userData['updatedAt'] = new DateTime();
            
            // Create user based on role
            if ($userData['role'] === 'jobseeker') {
                $userData['jobseeker_id'] = 'PRO_' . time();
                $userData['name'] = $userData['full_name'];
                $userData['qualification'] = '';
                $userData['dateOfBirth'] = '';
                $userData['profileImageUrl'] = '';
                $userData['experience'] = '';
                $userData['contact'] = $userData['phone'];
                $userData['location'] = '';
                $userData['jobDesignation'] = '';
                $userData['resumeUrl'] = '';
                $userData['resumeFileName'] = '';
                
                $result = $this->db->createJobseeker($email, $userData);
            } else {
                $userData['id'] = 'REC_' . time();
                $userData['name'] = $userData['full_name'];
                $userData['contact'] = $userData['phone'];
                $userData['designation'] = '';
                $userData['photoUrl'] = '';
                
                $result = $this->db->createRecruiter($email, $userData);
            }
            
            if ($result) {
                // Set session
                $_SESSION['user_id'] = $email;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = $userData['role'];
                $_SESSION['user_name'] = $userData['full_name'];
                
                return ['success' => true, 'user' => $userData];
            } else {
                return ['success' => false, 'error' => 'Failed to create user'];
            }
            
        } catch (Exception $e) {
            logError("Registration error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Registration failed'];
        }
    }
    
    public function login($email, $password) {
        try {
            // Check jobseeker first
            $user = $this->db->getJobseekerByEmail($email);
            $role = 'jobseeker';
            
            // If not found, check recruiter
            if (!$user) {
                $user = $this->db->getRecruiterByEmail($email);
                $role = 'recruiter';
            }
            
            if (!$user) {
                return ['success' => false, 'error' => 'Invalid email or password'];
            }
            
            // Verify password
            if (!password_verify($password, $user['password'])) {
                return ['success' => false, 'error' => 'Invalid email or password'];
            }
            
            // Set session
            $_SESSION['user_id'] = $email;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = $role;
            $_SESSION['user_name'] = $user['name'] ?? $user['full_name'] ?? '';
            
            return ['success' => true, 'user' => $user];
            
        } catch (Exception $e) {
            logError("Login error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Login failed'];
        }
    }
    
    public function logout() {
        session_destroy();
        return true;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function getUserRole() {
        return $_SESSION['user_role'] ?? null;
    }
    
    public function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }
    
    public function getUserEmail() {
        return $_SESSION['user_email'] ?? null;
    }
}
?>