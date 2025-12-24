<?php
$pageTitle = "Server Error";
require_once 'includes/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="text-center max-w-lg">
        <div class="mb-8">
            <div class="text-9xl font-bold text-red-600 mb-4">500</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Internal Server Error</h1>
            <p class="text-gray-600 mb-8">
                Something went wrong on our end. Our team has been notified and we're working to fix the issue.
                Please try again later.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="/" class="block bg-blue-600 text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-blue-700 transition duration-300">
                <i class="fas fa-home mr-2"></i>Go to Homepage
            </a>
            <a href="javascript:location.reload()" class="block border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-blue-50 transition duration-300">
                <i class="fas fa-redo mr-2"></i>Refresh Page
            </a>
        </div>
        
        <div class="mt-8 text-gray-500">
            <p>If the problem persists, please <a href="contact.php" class="text-blue-600 hover:text-blue-800">contact our support team</a>.</p>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>