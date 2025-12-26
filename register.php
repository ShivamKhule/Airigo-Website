<?php
require_once __DIR__ . '/includes/auth.php';
$auth = new Auth();

$type = $_GET['type'] ?? 'jobseeker';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $error = "Invalid request. Please try again.";
    } else {
        $email = sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $full_name = sanitizeInput($_POST['full_name'] ?? '');
        $phone = sanitizeInput($_POST['phone'] ?? '');
        
        // Validation
        $errors = [];
        
        if (empty($email) || empty($password) || empty($full_name) || empty($phone)) {
            $errors[] = "Please fill in all required fields.";
        }
        
        if (!isValidEmail($email)) {
            $errors[] = "Please enter a valid email address.";
        }
        
        if (!isValidPhone($phone)) {
            $errors[] = "Please enter a valid phone number.";
        }
        
        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }
        
        $passwordErrors = validatePasswordStrength($password);
        $errors = array_merge($errors, $passwordErrors);
        
        if (!isset($_POST['terms'])) {
            $errors[] = "You must agree to the Terms of Service and Privacy Policy.";
        }
        
        if (empty($errors)) {
            $userData = [
                'role' => $type,
                'full_name' => $full_name,
                'phone' => $phone,
                'profile_complete' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            if ($type === 'recruiter') {
                $userData['company_name'] = sanitizeInput($_POST['company_name'] ?? '');
                $userData['company_size'] = sanitizeInput($_POST['company_size'] ?? '');
                
                if (empty($userData['company_name'])) {
                    $errors[] = "Company name is required for recruiters.";
                }
            }
            
            if (empty($errors)) {
                $result = $auth->register($email, $password, $userData);
                
                if ($result['success']) {
                    // Log successful registration
                    logActivity($_SESSION['user_id'], 'register', ['role' => $type, 'ip' => getClientIP()]);
                    
                    // Send welcome email
                    sendEmailNotification($email, 'Welcome to Airigojobs', 'welcome-' . $type, $userData);
                    
                    setFlashMessage('success', 'Account created successfully! Please complete your profile.');
                    header('Location: ' . $baseUrl . '/profile.php?new=1');
                    exit();
                } else {
                    $errors[] = $result['error'];
                }
            }
        }
        
        if (!empty($errors)) {
            $error = implode('<br>', $errors);
        }
    }
}

$pageTitle = "Register";
require_once 'includes/header.php';
?>

<div class="min-h-[80vh] bg-gray-50 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Create Your <?php echo ucfirst($type); ?> Account
            </h1>
            <p class="text-lg text-gray-600">
                Join Airigojobs to <?php echo $type === 'jobseeker' ? 'find your dream job' : 'find qualified candidates'; ?>
            </p>
        </div>
        
        <!-- Role Selection -->
        <div class="flex justify-center mb-8">
            <div class="inline-flex   border border-gray-200 p-1">
                <a href="?type=jobseeker" 
                   class="px-6 py-3   font-medium <?php echo $type === 'jobseeker' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:text-blue-600'; ?>">
                    <i class="fas fa-user mr-2"></i>Job Seeker
                </a>
                <a href="?type=recruiter" 
                   class="px-6 py-3   font-medium <?php echo $type === 'recruiter' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:text-blue-600'; ?>">
                    <i class="fas fa-building mr-2"></i>Employer
                </a>
            </div>
        </div>
        
        <?php echo displayFlashMessages(); ?>
        
        <div class="bg-white   shadow-lg p-8">
            <form class="space-y-6" action="" method="POST">
                <?php echo csrfField(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Personal Information</h3>
                        
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Full Name *
                            </label>
                            <input type="text" 
                                   id="full_name" 
                                   name="full_name" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Enter your full name">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email Address *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Enter your email address">
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Phone Number *
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Enter your phone number">
                        </div>
                        
                        <?php if ($type === 'recruiter'): ?>
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Company Name *
                            </label>
                            <input type="text" 
                                   id="company_name" 
                                   name="company_name" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Enter your company name">
                        </div>
                        
                        <div>
                            <label for="company_size" class="block text-sm font-medium text-gray-700 mb-1">
                                Company Size
                            </label>
                            <select id="company_size" 
                                    name="company_size"
                                    class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select company size</option>
                                <option value="1-10">1-10 employees</option>
                                <option value="11-50">11-50 employees</option>
                                <option value="51-200">51-200 employees</option>
                                <option value="201-500">201-500 employees</option>
                                <option value="500+">500+ employees</option>
                            </select>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Security Information -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Security Information</h3>
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Password *
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required
                                   minlength="8"
                                   class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Create a password (min. 8 characters)">
                            <p class="mt-1 text-sm text-gray-500">Use at least 8 characters with a mix of letters, numbers & symbols</p>
                        </div>
                        
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirm Password *
                            </label>
                            <input type="password" 
                                   id="confirm_password" 
                                   name="confirm_password" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Confirm your password">
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="mt-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" 
                                           name="terms" 
                                           type="checkbox" 
                                           required
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300  ">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">
                                        I agree to the 
                                        <a href="<?php echo $baseUrl; ?>/terms.php" class="text-blue-600 hover:text-blue-500">Terms of Service</a>
                                        and 
                                        <a href="<?php echo $baseUrl; ?>/privacy.php" class="text-blue-600 hover:text-blue-500">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full bg-blue-600 text-white py-4 px-6   font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300">
                                <i class="fas fa-user-plus mr-2"></i>
                                Create <?php echo $type === 'jobseeker' ? 'Job Seeker' : 'Employer'; ?> Account
                            </button>
                        </div>
                        
                        <!-- Login Link -->
                        <div class="text-center pt-4 border-t">
                            <p class="text-gray-600">
                                Already have an account?
                                <a href="<?php echo $baseUrl; ?>/login.php" class="font-medium text-blue-600 hover:text-blue-500">
                                    Sign in here
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Benefits Section -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6   shadow text-center">
                <div class="bg-blue-100 w-16 h-16   flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                </div>
                <h4 class="font-bold text-lg mb-2 text-gray-800">Secure Platform</h4>
                <p class="text-gray-600">Your data is protected with enterprise-grade security</p>
            </div>
            
            <div class="bg-white p-6   shadow text-center">
                <div class="bg-blue-100 w-16 h-16   flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bolt text-blue-600 text-2xl"></i>
                </div>
                <h4 class="font-bold text-lg mb-2 text-gray-800">Quick Setup</h4>
                <p class="text-gray-600">Get started in minutes with our easy registration process</p>
            </div>
            
            <div class="bg-white p-6   shadow text-center">
                <div class="bg-blue-100 w-16 h-16   flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-blue-600 text-2xl"></i>
                </div>
                <h4 class="font-bold text-lg mb-2 text-gray-800">24/7 Support</h4>
                <p class="text-gray-600">Our team is always ready to help you with any questions</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>