<?php
session_start();

// Include required files
require_once __DIR__ . '/includes/functions.php';

// Log logout activity if user was logged in
if (isset($_SESSION['user_id'])) {
    logActivity($_SESSION['user_id'], 'logout', ['ip' => getClientIP()]);
}

// Clear all session variables
$_SESSION = array();

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Set flash message for next session
session_start();
setFlashMessage('success', 'You have been successfully logged out.');

// Redirect to home page
$baseUrl = getBaseUrl();
header("Location: {$baseUrl}/");
exit();
?>