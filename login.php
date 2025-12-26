<?php
require_once __DIR__ . '/includes/auth.php';
$auth = new Auth();

$error = '';
$selectedRole = $_POST['role'] ?? $_GET['role'] ?? 'jobseeker'; // Default to jobseeker

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $error = "Invalid request. Please try again.";
    } else {
        $email = sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'jobseeker';
        
        if (empty($email) || empty($password)) {
            $error = "Please fill in all fields.";
            $selectedRole = $role; // Preserve selection on error
        } else {
            // Pass role to your login method if needed (modify Auth::login accordingly)
            $result = $auth->login($email, $password, $role);
            
            if ($result['success']) {
                logActivity($_SESSION['user_id'], 'login', ['ip' => getClientIP()]);
                // Optional: redirect based on role
                $dashboard = ($_SESSION['user_role'] ?? $role) === 'recruiter' 
                    ? 'recruiter/dashboard.php' 
                    : 'seeker/dashboard.php';
                $redirect = $_GET['redirect'] ?? $dashboard;
                header('Location: ' . $redirect);
                exit();
            } else {
                $error = $result['error'];
                $selectedRole = $role; // Preserve on failed login
                logActivity(null, 'failed_login', ['email' => $email, 'ip' => getClientIP()]);
            }
        }
    }
}

$pageTitle = "Login";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-slate-50 flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <a href="<?php echo $baseUrl; ?>/" class="flex items-center justify-center gap-2 mb-8">
            <i class="fas fa-briefcase text-4xl text-blue-600"></i>
            <span class="font-bold text-2xl tracking-tight text-gray-900">Airigojobs</span>
        </a>

        <!-- Login Card -->
        <div class="bg-white   shadow-md">
            <div class="px-8 pt-8 pb-6 text-center border-b border-gray-200">
                <h3 class="text-2xl font-semibold text-gray-900">Welcome Back</h3>
                <p class="mt-2 text-sm text-gray-600">Enter your credentials to access your account</p>
            </div>

            <div class="p-8">
                <?php if ($error): ?>
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700   text-sm">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php echo displayFlashMessages(); ?>

                <form method="POST" action="" class="space-y-6">
                    <?php echo csrfField(); ?>
                    <input type="hidden" name="role" id="role-input" value="<?php echo htmlspecialchars($selectedRole); ?>">

                    <!-- Role Selection -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <button
                            type="button"
                            onclick="selectRole('jobseeker')"
                            class="py-3 px-4   font-medium transition-colors <?php echo $selectedRole === 'jobseeker' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>"
                        >
                            <i class="fas fa-user mr-2"></i>
                            Job Seeker
                        </button>
                        <button
                            type="button"
                            onclick="selectRole('recruiter')"
                            class="py-3 px-4   font-medium transition-colors <?php echo $selectedRole === 'recruiter' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>"
                        >
                            <i class="fas fa-building mr-2"></i>
                            Recruiter
                        </button>
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            placeholder="Enter your email"
                            class="w-full h-12 px-4 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        />
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                placeholder="Enter your password"
                                class="w-full h-12 px-4 pr-12 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400"
                            />
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                            >
                                <i id="eye-icon" class="fas fa-eye text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full h-12 bg-blue-600 hover:bg-blue-700 text-white font-medium   transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Sign In
                    </button>
                </form>

                <!-- Register Link -->
                <p class="mt-8 text-center text-sm text-gray-600">
                    Don't have an account? 
                    <a href="<?php echo $baseUrl; ?>/register.php" class="font-medium text-blue-600 hover:underline">
                        Create one
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function selectRole(role) {
    document.getElementById('role-input').value = role;

    // Update button styles
    document.querySelectorAll('[onclick^="selectRole"]').forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
    });

    event.target.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
    event.target.classList.add('bg-blue-600', 'text-white');
}

function togglePassword() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

// On page load, highlight the currently selected role
document.addEventListener('DOMContentLoaded', () => {
    const selected = '<?php echo addslashes($selectedRole); ?>';
    document.querySelector(`[onclick="selectRole('${selected}')"]`)?.classList.add('bg-blue-600', 'text-white');
    document.querySelector(`[onclick="selectRole('${selected}')"]`)?.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
});
</script>

<?php require_once 'includes/footer.php'; ?>