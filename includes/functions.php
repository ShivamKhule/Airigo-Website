<?php
/**
 * Enhanced Functions for Airigojobs
 * Production-ready helper functions with proper error handling
 */

// Include configuration
require_once __DIR__ . '/../config/config.php';

/**
 * Get base URL with proper handling for different environments
 */
function getBaseUrl()
{
    // Check if we're in CLI mode
    if (php_sapi_name() === 'cli') {
        return Config::get('app.url', 'http://localhost');
    }

    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = $_SERVER['SCRIPT_NAME'] ?? '';

    // Remove the script filename and get directory
    $path = dirname($script);

    // Clean up path
    if ($path === '/' || $path === '\\') {
        $path = '';
    }

    return rtrim($protocol . $host . $path, '/');
}

/**
 * Get current page URL
 */
function getCurrentPageUrl()
{
    if (php_sapi_name() === 'cli') {
        return Config::get('app.url', 'http://localhost');
    }

    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $uri = $_SERVER['REQUEST_URI'] ?? '/';

    return $protocol . $host . $uri;
}

/**
 * Sanitize input data
 */
function sanitizeInput($data)
{
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email address
 */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number (basic validation)
 */
function isValidPhone($phone)
{
    // Remove all non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    // Check if phone number is between 10-15 digits
    return strlen($phone) >= 10 && strlen($phone) <= 15;
}

/**
 * Generate random token for password reset or verification
 */
function generateToken($length = 32)
{
    return bin2hex(random_bytes($length));
}

/**
 * Format date for display
 */
function formatDate($date, $format = 'F j, Y')
{
    if (empty($date))
        return '';
    return date($format, strtotime($date));
}

/**
 * Calculate time ago from timestamp
 */
function timeAgo($timestamp)
{
    $time = time() - strtotime($timestamp);

    if ($time < 60) {
        return 'just now';
    } elseif ($time < 3600) {
        $minutes = floor($time / 60);
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
    } elseif ($time < 86400) {
        $hours = floor($time / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($time < 604800) {
        $days = floor($time / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } elseif ($time < 2592000) {
        $weeks = floor($time / 604800);
        return $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
    } elseif ($time < 31536000) {
        $months = floor($time / 2592000);
        return $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
    } else {
        $years = floor($time / 31536000);
        return $years . ' year' . ($years > 1 ? 's' : '') . ' ago';
    }
}

/**
 * Truncate text with ellipsis
 */
function truncateText($text, $length = 100, $ellipsis = '...')
{
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $ellipsis;
}

/**
 * Enhanced error logging with context
 */
function logError($message, $context = [])
{
    $logMessage = date('Y-m-d H:i:s') . ' - ' . $message;
    if (!empty($context)) {
        $logMessage .= ' - Context: ' . json_encode($context);
    }

    error_log($logMessage);

    // In development, also log to file
    if (Config::isDebug()) {
        $logFile = __DIR__ . '/../logs/error.log';
        if (!file_exists(dirname($logFile))) {
            mkdir(dirname($logFile), 0755, true);
        }
        file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

/**
 * Rate limiting function
 */
function checkRateLimit($identifier, $maxRequests = null, $timeWindow = null)
{
    if (!Config::get('rate_limit.enabled', false)) {
        return true;
    }

    $maxRequests = $maxRequests ?? Config::get('rate_limit.requests', 100);
    $timeWindow = $timeWindow ?? Config::get('rate_limit.window', 3600);

    $cacheKey = 'rate_limit_' . md5($identifier);
    $requests = cacheGet($cacheKey) ?? [];

    // Clean old requests
    $currentTime = time();
    $requests = array_filter($requests, function ($timestamp) use ($currentTime, $timeWindow) {
        return ($currentTime - $timestamp) < $timeWindow;
    });

    // Check if limit exceeded
    if (count($requests) >= $maxRequests) {
        return false;
    }

    // Add current request
    $requests[] = $currentTime;
    cacheSet($cacheKey, $requests, $timeWindow);

    return true;
}

/**
 * Enhanced file upload with better security
 */
function uploadFileSecure($file, $allowedTypes = null, $maxSize = null, $uploadDir = 'assets/uploads/')
{
    $errors = [];
    $uploadedPath = null;

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "File upload error: " . $file['error'];
        return ['success' => false, 'errors' => $errors];
    }

    // Get configuration
    $allowedTypes = $allowedTypes ?? Config::get('upload.allowed_types', ['jpg', 'jpeg', 'png', 'pdf']);
    $maxSize = $maxSize ?? Config::get('upload.max_size', 5242880);

    // Check file size
    if ($file['size'] > $maxSize) {
        $errors[] = "File size exceeds maximum allowed size of " . formatFileSize($maxSize);
    }

    // Get file extension
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Check file type
    if (!in_array($fileExt, $allowedTypes)) {
        $errors[] = "File type not allowed. Allowed types: " . implode(', ', $allowedTypes);
    }

    // Check MIME type for additional security
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowedMimes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    if (isset($allowedMimes[$fileExt]) && $mimeType !== $allowedMimes[$fileExt]) {
        $errors[] = "File type mismatch. Expected {$allowedMimes[$fileExt]}, got {$mimeType}";
    }

    // Generate secure filename
    $newFilename = bin2hex(random_bytes(16)) . '_' . time() . '.' . $fileExt;
    $uploadPath = $uploadDir . date('Y/m/') . $newFilename;

    // Create directory structure
    $fullUploadDir = dirname($uploadPath);
    if (!file_exists($fullUploadDir)) {
        mkdir($fullUploadDir, 0755, true);
    }

    if (empty($errors)) {
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Set proper permissions
            chmod($uploadPath, 0644);
            $uploadedPath = $uploadPath;
        } else {
            $errors[] = "Failed to move uploaded file";
        }
    }

    return [
        'success' => empty($errors),
        'path' => $uploadedPath,
        'errors' => $errors,
        'filename' => $newFilename ?? null
    ];
}

/**
 * Delete uploaded file
 */
function deleteFile($filepath)
{
    if (file_exists($filepath) && is_file($filepath)) {
        return unlink($filepath);
    }
    return false;
}

/**
 * Get current URL
 */
function currentUrl()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Redirect to another page
 */
function redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    exit();
}

/**
 * Check if user is logged in (alternative to Auth class)
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get user ID from session
 */
function getUserId()
{
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get user role from session
 */
function getUserRole()
{
    return $_SESSION['user_role'] ?? null;
}

/**
 * Generate pagination HTML
 */
function generatePagination($totalItems, $currentPage, $itemsPerPage, $urlPattern = '?page={page}')
{
    $totalPages = ceil($totalItems / $itemsPerPage);

    if ($totalPages <= 1) {
        return '';
    }

    $html = '<nav class="flex justify-center mt-8" aria-label="Pagination">';
    $html .= '<ul class="inline-flex items-center -space-x-px">';

    // Previous button
    if ($currentPage > 1) {
        $html .= '<li>';
        $html .= '<a href="' . str_replace('{page}', $currentPage - 1, $urlPattern) . '" class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">';
        $html .= '<span class="sr-only">Previous</span>';
        $html .= '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
        $html .= '</a>';
        $html .= '</li>';
    }

    // Page numbers
    $startPage = max(1, $currentPage - 2);
    $endPage = min($totalPages, $currentPage + 2);

    for ($i = $startPage; $i <= $endPage; $i++) {
        if ($i == $currentPage) {
            $html .= '<li>';
            $html .= '<a href="#" aria-current="page" class="z-10 px-3 py-2 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">' . $i . '</a>';
            $html .= '</li>';
        } else {
            $html .= '<li>';
            $html .= '<a href="' . str_replace('{page}', $i, $urlPattern) . '" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">' . $i . '</a>';
            $html .= '</li>';
        }
    }

    // Next button
    if ($currentPage < $totalPages) {
        $html .= '<li>';
        $html .= '<a href="' . str_replace('{page}', $currentPage + 1, $urlPattern) . '" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">';
        $html .= '<span class="sr-only">Next</span>';
        $html .= '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
        $html .= '</a>';
        $html .= '</li>';
    }

    $html .= '</ul>';
    $html .= '</nav>';

    return $html;
}

/**
 * Generate breadcrumb navigation
 */
function generateBreadcrumbs($items)
{
    if (empty($items)) {
        return '';
    }

    $html = '<nav class="flex mb-6" aria-label="Breadcrumb">';
    $html .= '<ol class="inline-flex items-center space-x-1 md:space-x-3">';

    $itemCount = count($items);
    $i = 0;

    foreach ($items as $label => $url) {
        $i++;

        if ($i == 1) {
            // Home icon for first item
            $html .= '<li class="inline-flex items-center">';
            $html .= '<a href="' . $url . '" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">';
            $html .= '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>';
            $html .= $label;
            $html .= '</a>';
            $html .= '</li>';
        } elseif ($i == $itemCount) {
            // Current page (last item)
            $html .= '<li aria-current="page">';
            $html .= '<div class="flex items-center">';
            $html .= '<svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
            $html .= '<span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">' . $label . '</span>';
            $html .= '</div>';
            $html .= '</li>';
        } else {
            // Middle items
            $html .= '<li>';
            $html .= '<div class="flex items-center">';
            $html .= '<svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
            $html .= '<a href="' . $url . '" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">' . $label . '</a>';
            $html .= '</div>';
            $html .= '</li>';
        }
    }

    $html .= '</ol>';
    $html .= '</nav>';

    return $html;
}

/**
 * Generate job status badge
 */
function generateStatusBadge($status)
{
    $statusConfig = [
        'active' => ['color' => 'green', 'text' => 'Active'],
        'draft' => ['color' => 'yellow', 'text' => 'Draft'],
        'pending' => ['color' => 'blue', 'text' => 'Pending'],
        'closed' => ['color' => 'gray', 'text' => 'Closed'],
        'expired' => ['color' => 'red', 'text' => 'Expired'],
        'applied' => ['color' => 'blue', 'text' => 'Applied'],
        'shortlisted' => ['color' => 'purple', 'text' => 'Shortlisted'],
        'interview' => ['color' => 'yellow', 'text' => 'Interview'],
        'rejected' => ['color' => 'red', 'text' => 'Rejected'],
        'hired' => ['color' => 'green', 'text' => 'Hired']
    ];

    $config = $statusConfig[strtolower($status)] ?? ['color' => 'gray', 'text' => ucfirst($status)];

    $colorClasses = [
        'green' => 'bg-green-100 text-green-800',
        'yellow' => 'bg-yellow-100 text-yellow-800',
        'blue' => 'bg-blue-100 text-blue-800',
        'purple' => 'bg-purple-100 text-purple-800',
        'red' => 'bg-red-100 text-red-800',
        'gray' => 'bg-gray-100 text-gray-800'
    ];

    $colorClass = $colorClasses[$config['color']] ?? 'bg-gray-100 text-gray-800';

    return '<span class="px-3 py-1 rounded-full text-sm font-medium ' . $colorClass . '">' . $config['text'] . '</span>';
}

/**
 * Format salary for display
 */
function formatSalary($min, $max, $type = 'yearly')
{
    if (empty($min) && empty($max)) {
        return 'Not specified';
    }

    $formatted = '';

    if (!empty($min)) {
        $formatted .= '$' . number_format($min);
    }

    if (!empty($max)) {
        if (!empty($formatted)) {
            $formatted .= ' - ';
        }
        $formatted .= '$' . number_format($max);
    }

    // Add type suffix
    $suffixes = [
        'yearly' => '/year',
        'monthly' => '/month',
        'weekly' => '/week',
        'hourly' => '/hour'
    ];

    if (isset($suffixes[$type])) {
        $formatted .= $suffixes[$type];
    }

    return $formatted;
}

/**
 * Get job type label
 */
function getJobTypeLabel($type)
{
    $types = [
        'full-time' => 'Full-time',
        'part-time' => 'Part-time',
        'contract' => 'Contract',
        'internship' => 'Internship',
        'temporary' => 'Temporary',
        'remote' => 'Remote',
        'freelance' => 'Freelance'
    ];

    return $types[$type] ?? ucfirst($type);
}

/**
 * Get experience level label
 */
function getExperienceLabel($years)
{
    if ($years <= 1) {
        return 'Entry Level';
    } elseif ($years <= 3) {
        return 'Mid Level';
    } elseif ($years <= 7) {
        return 'Senior Level';
    } else {
        return 'Executive Level';
    }
}

/**
 * Enhanced email sending with configuration
 */
function sendEmailNotification($to, $subject, $template, $data = [])
{
    // Load email template
    $templatePath = __DIR__ . '/../emails/' . $template . '.php';

    if (!file_exists($templatePath)) {
        logError("Email template not found: {$template}");
        return false;
    }

    try {
        ob_start();
        extract($data);
        include $templatePath;
        $message = ob_get_clean();

        // Get mail configuration
        $fromAddress = Config::get('mail.from_address', 'noreply@localhost');
        $fromName = Config::get('mail.from_name', 'Airigojobs');

        // Headers for HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: {$fromName} <{$fromAddress}>" . "\r\n";
        $headers .= "Reply-To: {$fromAddress}" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

        $result = mail($to, $subject, $message, $headers);

        if ($result) {
            logActivity(null, 'email_sent', ['to' => $to, 'template' => $template]);
        } else {
            logError("Failed to send email", ['to' => $to, 'template' => $template]);
        }

        return $result;

    } catch (Exception $e) {
        logError("Email sending error: " . $e->getMessage(), ['to' => $to, 'template' => $template]);
        return false;
    }
}

/**
 * Enhanced activity logging with better error handling
 */
function logActivity($userId, $action, $details = [])
{
    try {
        $logEntry = [
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
            'ip_address' => getClientIP(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'timestamp' => date('Y-m-d H:i:s'),
            'session_id' => session_id()
        ];

        // Create logs directory if it doesn't exist
        $logDir = __DIR__ . '/../logs';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $logFile = $logDir . '/activity_' . date('Y-m') . '.log';
        $logLine = json_encode($logEntry) . PHP_EOL;

        return file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX) !== false;

    } catch (Exception $e) {
        error_log("Activity logging error: " . $e->getMessage());
        return false;
    }
}

/**
 * Validate password strength
 */
function validatePasswordStrength($password)
{
    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter";
    }

    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter";
    }

    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must contain at least one number";
    }

    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors[] = "Password must contain at least one special character";
    }

    return $errors;
}

/**
 * Get user's initials for avatar
 */
function getUserInitials($name)
{
    $initials = '';
    $words = explode(' ', $name);

    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= strtoupper($word[0]);
        }
    }

    return substr($initials, 0, 2);
}

/**
 * Get user's avatar color based on name
 */
function getUserAvatarColor($name)
{
    $colors = [
        'bg-blue-600',
        'bg-green-600',
        'bg-purple-600',
        'bg-pink-600',
        'bg-red-600',
        'bg-yellow-600',
        'bg-indigo-600',
        'bg-teal-600'
    ];

    $hash = crc32($name);
    $index = abs($hash) % count($colors);

    return $colors[$index];
}

/**
 * Generate SEO-friendly URL slug
 */
function generateSlug($text)
{
    $slug = strtolower($text);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    $slug = preg_replace('/-+/', '-', $slug);

    return $slug;
}

/**
 * Check if string contains HTML
 */
function containsHTML($string)
{
    return $string != strip_tags($string);
}

/**
 * Escape string for JavaScript
 */
function escapeJS($string)
{
    return addslashes($string);
}

/**
 * Generate UUID
 */
function generateUUID()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

/**
 * Calculate percentage
 */
function calculatePercentage($part, $total)
{
    if ($total == 0)
        return 0;
    return round(($part / $total) * 100, 2);
}

/**
 * Format file size
 */
function formatFileSize($bytes)
{
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

/**
 * Get file icon based on extension
 */
function getFileIcon($filename)
{
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $icons = [
        'pdf' => 'fas fa-file-pdf text-red-600',
        'doc' => 'fas fa-file-word text-blue-600',
        'docx' => 'fas fa-file-word text-blue-600',
        'jpg' => 'fas fa-file-image text-green-600',
        'jpeg' => 'fas fa-file-image text-green-600',
        'png' => 'fas fa-file-image text-green-600',
        'gif' => 'fas fa-file-image text-green-600',
        'txt' => 'fas fa-file-alt text-gray-600',
        'csv' => 'fas fa-file-csv text-green-600',
        'xls' => 'fas fa-file-excel text-green-600',
        'xlsx' => 'fas fa-file-excel text-green-600'
    ];

    return $icons[$extension] ?? 'fas fa-file text-gray-600';
}

/**
 * Check if request is AJAX
 */
function isAjaxRequest()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Set flash message
 */
function setFlashMessage($type, $message)
{
    $_SESSION['flash_messages'][] = [
        'type' => $type,
        'message' => $message,
        'timestamp' => time()
    ];
}

/**
 * Get flash messages
 */
function getFlashMessages()
{
    $messages = $_SESSION['flash_messages'] ?? [];
    unset($_SESSION['flash_messages']);
    return $messages;
}

/**
 * Display flash messages
 */
function displayFlashMessages()
{
    $messages = getFlashMessages();

    if (empty($messages)) {
        return '';
    }

    $html = '';
    foreach ($messages as $message) {
        $alertClasses = [
            'success' => 'bg-green-100 border-green-400 text-green-700',
            'error' => 'bg-red-100 border-red-400 text-red-700',
            'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
            'info' => 'bg-blue-100 border-blue-400 text-blue-700'
        ];

        $class = $alertClasses[$message['type']] ?? $alertClasses['info'];

        $html .= '<div class="mb-4 px-4 py-3 rounded relative ' . $class . '" role="alert">';
        $html .= '<span class="block sm:inline">' . htmlspecialchars($message['message']) . '</span>';
        $html .= '<button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">';
        $html .= '<i class="fas fa-times"></i>';
        $html .= '</button>';
        $html .= '</div>';
    }

    return $html;
}

/**
 * Enhanced cache functions with better error handling
 */
function cacheSet($key, $data, $ttl = null)
{
    if (!Config::get('cache.enabled', true)) {
        return false;
    }

    $ttl = $ttl ?? Config::get('cache.lifetime', 3600);
    $cacheDir = __DIR__ . '/../cache';

    if (!file_exists($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }

    $cacheFile = $cacheDir . '/' . md5($key) . '.cache';

    $cacheData = [
        'data' => $data,
        'expires' => time() + $ttl,
        'created' => time()
    ];

    try {
        return file_put_contents($cacheFile, serialize($cacheData), LOCK_EX) !== false;
    } catch (Exception $e) {
        logError("Cache set error: " . $e->getMessage(), ['key' => $key]);
        return false;
    }
}

function cacheGet($key)
{
    if (!Config::get('cache.enabled', true)) {
        return null;
    }

    $cacheFile = __DIR__ . '/../cache/' . md5($key) . '.cache';

    if (!file_exists($cacheFile)) {
        return null;
    }

    try {
        $cacheData = unserialize(file_get_contents($cacheFile));

        if (!$cacheData || $cacheData['expires'] < time()) {
            unlink($cacheFile);
            return null;
        }

        return $cacheData['data'];

    } catch (Exception $e) {
        logError("Cache get error: " . $e->getMessage(), ['key' => $key]);
        // Clean up corrupted cache file
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
        return null;
    }
}

/**
 * Clear cache with better error handling
 */
function cacheClear($key = null)
{
    $cacheDir = __DIR__ . '/../cache';

    if (!file_exists($cacheDir)) {
        return true;
    }

    try {
        if ($key) {
            $cacheFile = $cacheDir . '/' . md5($key) . '.cache';
            if (file_exists($cacheFile)) {
                return unlink($cacheFile);
            }
        } else {
            $files = glob($cacheDir . '/*.cache');
            $success = true;
            foreach ($files as $file) {
                if (!unlink($file)) {
                    $success = false;
                }
            }
            return $success;
        }
        return true;
    } catch (Exception $e) {
        logError("Cache clear error: " . $e->getMessage(), ['key' => $key]);
        return false;
    }
}

/**
 * Get client IP address
 */
function getClientIP()
{
    $ip = '';

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

/**
 * Enhanced CSRF token functions with expiration
 */
function generateCSRFToken()
{
    $lifetime = Config::get('security.csrf_token_lifetime', 3600);

    if (
        !isset($_SESSION['csrf_token']) ||
        !isset($_SESSION['csrf_token_time']) ||
        (time() - $_SESSION['csrf_token_time']) > $lifetime
    ) {

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
    }

    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token)
{
    if (!isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_time'])) {
        return false;
    }

    $lifetime = Config::get('security.csrf_token_lifetime', 3600);

    // Check if token has expired
    if ((time() - $_SESSION['csrf_token_time']) > $lifetime) {
        unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get CSRF token field
 */
function csrfField()
{
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Debug function (for development only)
 */
function debug($data, $die = false)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    if ($die) {
        die();
    }
}

/**
 * Get user location from IP (basic implementation)
 */
function getUserLocation($ip = null)
{
    if ($ip === null) {
        $ip = getClientIP();
    }

    // For development, return default location
    if ($ip === '127.0.0.1' || $ip === '::1') {
        return [
            'country' => 'Localhost',
            'city' => 'Local',
            'timezone' => 'UTC'
        ];
    }

    // In production, you would use an IP geolocation service
    // This is a simplified example
    return [
        'country' => 'Unknown',
        'city' => 'Unknown',
        'timezone' => 'UTC'
    ];
}

// function firestoreTimeAgo($dateString)
// {
//     if (empty($dateString)) {
//         return 'Recently';
//     }

//     // Firestore ISO 8601 with microseconds
//     $formats = [
//         'Y-m-d\TH:i:s.uP', // 2025-11-13T05:30:02.788000+00:00
//         'Y-m-d\TH:i:sP',   // fallback without microseconds
//     ];

//     foreach ($formats as $format) {
//         $date = DateTime::createFromFormat($format, $dateString);
//         if ($date !== false) {
//             return timeAgo($date->getTimestamp());
//         }
//     }

//     return 'Recently';
// }

function formatPostedTime($createdAt)
{
    if (empty($createdAt)) {
        return 'Recently';
    }

    // Try to parse human-readable date
    $timestamp = strtotime($createdAt);

    if ($timestamp === false) {
        return htmlspecialchars($createdAt); // fallback: show raw value
    }

    return timeAgo(date('Y-m-d H:i:s', $timestamp));
}

function getPostedText($job)
{
    // 1. Key does not exist
    if (!isset($job['createdAt']) || empty($job['createdAt'])) {
        return 'Date not available';
    }

    $rawDate = $job['createdAt'];

    // 2. Normalize "10 November 2025 at 12:56:45 UTC+5:30"
    $normalized = str_replace([' at ', ' UTC'], ' ', $rawDate);

    $timestamp = strtotime($normalized);

    // 3. If parsing fails → show original date
    if ($timestamp === false) {
        return htmlspecialchars($rawDate);
    }

    // 4. Pass ISO format to timeAgo
    return timeAgo(date('Y-m-d H:i:s', $timestamp));
}


// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
