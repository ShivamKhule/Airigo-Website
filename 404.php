<?php
$pageTitle = "Page Not Found";
require_once 'includes/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="text-center max-w-lg">
        <div class="mb-8">
            <div class="text-9xl font-bold text-blue-600 mb-4">404</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Page Not Found</h1>
            <p class="text-gray-600 mb-8">
                The page you're looking for doesn't exist or has been moved. 
                Please check the URL or navigate back to the homepage.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="/" class="block bg-blue-600 text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-blue-700 transition duration-300">
                <i class="fas fa-home mr-2"></i>Go to Homepage
            </a>
            <a href="javascript:history.back()" class="block border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-blue-50 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Go Back
            </a>
        </div>
        
        <div class="mt-8 text-gray-500">
            <p>If you believe this is an error, please <a href="contact.php" class="text-blue-600 hover:text-blue-800">contact our support team</a>.</p>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>