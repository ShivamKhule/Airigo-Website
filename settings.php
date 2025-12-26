<?php
require_once 'includes/auth.php';
$auth = new Auth();

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$userId = $auth->getUserId();
$userRole = $auth->getUserRole();

// Get user settings from Firebase
require_once 'config/database.php';
$db = new Database();
$userData = $db->getData('users/' . $userId);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_notifications') {
        $notificationSettings = [
            'email_job_alerts' => isset($_POST['email_job_alerts']),
            'email_application_updates' => isset($_POST['email_application_updates']),
            'email_marketing' => isset($_POST['email_marketing']),
            'sms_notifications' => isset($_POST['sms_notifications']),
            'push_notifications' => isset($_POST['push_notifications']),
            'newsletter' => isset($_POST['newsletter']),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $db->updateData('users/' . $userId, $notificationSettings);
        $message = $result ? 'Notification settings updated successfully!' : 'Failed to update settings.';
        
    } elseif ($action === 'update_privacy') {
        $privacySettings = [
            'profile_visibility' => $_POST['profile_visibility'] ?? 'public',
            'show_email' => isset($_POST['show_email']),
            'show_phone' => isset($_POST['show_phone']),
            'show_location' => isset($_POST['show_location']),
            'data_sharing' => isset($_POST['data_sharing']),
            'search_engine_indexing' => isset($_POST['search_engine_indexing']),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $db->updateData('users/' . $userId, $privacySettings);
        $message = $result ? 'Privacy settings updated successfully!' : 'Failed to update settings.';
        
    } elseif ($action === 'update_account') {
        $accountData = [
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'language' => $_POST['language'] ?? 'en',
            'timezone' => $_POST['timezone'] ?? 'UTC',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $db->updateData('users/' . $userId, $accountData);
        $message = $result ? 'Account settings updated successfully!' : 'Failed to update settings.';
    }
}

$pageTitle = "Settings";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Account Settings</h1>
            <p class="text-gray-600">Manage your account preferences and privacy settings</p>
        </div>

        <?php if (isset($message)): ?>
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3   relative" role="alert">
            <span class="block sm:inline"><?php echo $message; ?></span>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Settings Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white   shadow-lg p-6 sticky top-8">
                    <nav class="space-y-2">
                        <a href="#notifications" 
                           class="block px-4 py-3   bg-blue-50 text-blue-600 font-medium">
                            <i class="fas fa-bell mr-2"></i>Notifications
                        </a>
                        <a href="#privacy" 
                           class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-shield-alt mr-2"></i>Privacy
                        </a>
                        <a href="#account" 
                           class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-user-cog mr-2"></i>Account
                        </a>
                        <a href="#security" 
                           class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-lock mr-2"></i>Security
                        </a>
                        <?php if ($userRole === 'recruiter'): ?>
                        <a href="#billing" 
                           class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-credit-card mr-2"></i>Billing
                        </a>
                        <?php endif; ?>
                        <a href="#integrations" 
                           class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-plug mr-2"></i>Integrations
                        </a>
                    </nav>
                    
                    <!-- Account Status -->
                    <div class="mt-8 pt-8 border-t">
                        <h3 class="font-bold text-gray-800 mb-4">Account Status</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500   mr-3"></div>
                                <span class="text-gray-700">Active</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500   mr-3"></div>
                                <span class="text-gray-700">Email Verified</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500   mr-3"></div>
                                <span class="text-gray-700">Phone Verified</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="lg:col-span-3">
                <!-- Notifications Settings -->
                <div id="notifications" class="bg-white   shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Notification Settings</h2>
                    
                    <form method="POST" action="" class="space-y-6">
                        <input type="hidden" name="action" value="update_notifications">
                        
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Email Notifications</h3>
                            <div class="space-y-4">
                                <label class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Job Alerts</p>
                                        <p class="text-gray-600 text-sm">Get notified about new job opportunities matching your profile</p>
                                    </div>
                                    <input type="checkbox" 
                                           name="email_job_alerts"
                                           <?php echo ($userData['email_job_alerts'] ?? true) ? 'checked' : ''; ?>
                                           class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                </label>
                                
                                <label class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Application Updates</p>
                                        <p class="text-gray-600 text-sm">Receive updates on your job applications</p>
                                    </div>
                                    <input type="checkbox" 
                                           name="email_application_updates"
                                           <?php echo ($userData['email_application_updates'] ?? true) ? 'checked' : ''; ?>
                                           class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                </label>
                                
                                <label class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Marketing Emails</p>
                                        <p class="text-gray-600 text-sm">Receive newsletters and promotional offers</p>
                                    </div>
                                    <input type="checkbox" 
                                           name="email_marketing"
                                           <?php echo ($userData['email_marketing'] ?? false) ? 'checked' : ''; ?>
                                           class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Other Notifications</h3>
                            <div class="space-y-4">
                                <label class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">SMS Notifications</p>
                                        <p class="text-gray-600 text-sm">Receive important updates via text message</p>
                                    </div>
                                    <input type="checkbox" 
                                           name="sms_notifications"
                                           <?php echo ($userData['sms_notifications'] ?? false) ? 'checked' : ''; ?>
                                           class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                </label>
                                
                                <label class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Push Notifications</p>
                                        <p class="text-gray-600 text-sm">Receive browser push notifications</p>
                                    </div>
                                    <input type="checkbox" 
                                           name="push_notifications"
                                           <?php echo ($userData['push_notifications'] ?? true) ? 'checked' : ''; ?>
                                           class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Frequency</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Job Alert Frequency
                                </label>
                                <select class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Daily Digest</option>
                                    <option>Immediate</option>
                                    <option>Weekly Summary</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="pt-6 border-t">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-3   font-medium hover:bg-blue-700">
                                Save Notification Settings
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Privacy Settings -->
                <div id="privacy" class="bg-white   shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Privacy Settings</h2>
                    
                    <form method="POST" action="" class="space-y-6">
                        <input type="hidden" name="action" value="update_privacy">
                        
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Profile Visibility</h3>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="profile_visibility" 
                                           value="public"
                                           <?php echo ($userData['profile_visibility'] ?? 'public') === 'public' ? 'checked' : ''; ?>
                                           class="h-4 w-4 text-blue-600">
                                    <span class="ml-3 text-gray-700">Public - Anyone can view my profile</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="profile_visibility" 
                                           value="employers"
                                           <?php echo ($userData['profile_visibility'] ?? 'public') === 'employers' ? 'checked' : ''; ?>
                                           class="h-4 w-4 text-blue-600">
                                    <span class="ml-3 text-gray-700">Employers Only - Only registered employers can view my profile</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="profile_visibility" 
                                           value="private"
                                           <?php echo ($userData['profile_visibility'] ?? 'public') === 'private' ? 'checked' : ''; ?>
                                           class="h-4 w-4 text-blue-600">
                                    <span class="ml-3 text-gray-700">Private - Only I can view my profile</span>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Information Sharing</h3>
                            <div class="space-y-4">
                                <label class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Show Email Address</p>
                                        <p class="text-gray-600 text-sm">Allow employers to see your email address</p>
                                    </div>
                                    <input type="checkbox" 
                                           name="show_email"
                                           <?php echo ($userData['show_email'] ?? false) ? 'checked' : ''; ?>
                                           class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                </label>
                                
                                <label class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Show Phone Number</p>
                                        <p class="text-gray-600 text-sm">Allow employers to see your phone number</p>
                                    </div>
                                    <input type="checkbox" 
                                           name="show_phone"
                                           <?php echo ($userData['show_phone'] ?? false) ? 'checked' : ''; ?>
                                           class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                </label>
                                
                                <label class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Show Location</p>
                                        <p class="text-gray-600 text-sm">Allow employers to see your location</p>
                                    </div>
                                    <input type="checkbox" 
                                           name="show_location"
                                           <?php echo ($userData['show_location'] ?? true) ? 'checked' : ''; ?>
                                           class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Data & Analytics</h3>
                            <div class="space-y-4">
                                <label class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Data Sharing for Analytics</p>
                                        <p class="text-gray-600 text-sm">Allow us to use your data to improve our services</p>
                                    </div>
                                    <input type="checkbox" 
                                           name="data_sharing"
                                           <?php echo ($userData['data_sharing'] ?? true) ? 'checked' : ''; ?>
                                           class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                </label>
                                
                                <label class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Search Engine Indexing</p>
                                        <p class="text-gray-600 text-sm">Allow search engines to index your profile</p>
                                    </div>
                                    <input type="checkbox" 
                                           name="search_engine_indexing"
                                           <?php echo ($userData['search_engine_indexing'] ?? false) ? 'checked' : ''; ?>
                                           class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                </label>
                            </div>
                        </div>
                        
                        <!-- Data Management -->
                        <div class="pt-6 border-t">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Data Management</h3>
                            <div class="space-y-3">
                                <button type="button" 
                                        class="w-full text-left p-4 border border-gray-300   hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-800">Download Your Data</p>
                                            <p class="text-gray-600 text-sm">Get a copy of all your personal data</p>
                                        </div>
                                        <i class="fas fa-download text-gray-400"></i>
                                    </div>
                                </button>
                                
                                <button type="button" 
                                        class="w-full text-left p-4 border border-gray-300   hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-800">Request Data Deletion</p>
                                            <p class="text-gray-600 text-sm">Request deletion of your personal data</p>
                                        </div>
                                        <i class="fas fa-trash text-gray-400"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                        
                        <div class="pt-6 border-t">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-3   font-medium hover:bg-blue-700">
                                Save Privacy Settings
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Settings -->
                <div id="account" class="bg-white   shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Account Settings</h2>
                    
                    <form method="POST" action="" class="space-y-6">
                        <input type="hidden" name="action" value="update_account">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address *
                                </label>
                                <input type="email" 
                                       name="email"
                                       value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number *
                                </label>
                                <input type="tel" 
                                       name="phone"
                                       value="<?php echo htmlspecialchars($userData['phone'] ?? ''); ?>"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Language
                                </label>
                                <select name="language" 
                                        class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="en" <?php echo ($userData['language'] ?? 'en') === 'en' ? 'selected' : ''; ?>>English</option>
                                    <option value="es" <?php echo ($userData['language'] ?? 'en') === 'es' ? 'selected' : ''; ?>>Spanish</option>
                                    <option value="fr" <?php echo ($userData['language'] ?? 'en') === 'fr' ? 'selected' : ''; ?>>French</option>
                                    <option value="de" <?php echo ($userData['language'] ?? 'en') === 'de' ? 'selected' : ''; ?>>German</option>
                                    <option value="ar" <?php echo ($userData['language'] ?? 'en') === 'ar' ? 'selected' : ''; ?>>Arabic</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Timezone
                                </label>
                                <select name="timezone" 
                                        class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="UTC" <?php echo ($userData['timezone'] ?? 'UTC') === 'UTC' ? 'selected' : ''; ?>>UTC</option>
                                    <option value="EST" <?php echo ($userData['timezone'] ?? 'UTC') === 'EST' ? 'selected' : ''; ?>>Eastern Time (EST)</option>
                                    <option value="PST" <?php echo ($userData['timezone'] ?? 'UTC') === 'PST' ? 'selected' : ''; ?>>Pacific Time (PST)</option>
                                    <option value="GMT" <?php echo ($userData['timezone'] ?? 'UTC') === 'GMT' ? 'selected' : ''; ?>>GMT</option>
                                    <option value="CET" <?php echo ($userData['timezone'] ?? 'UTC') === 'CET' ? 'selected' : ''; ?>>Central European Time (CET)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="pt-6 border-t">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-3   font-medium hover:bg-blue-700">
                                Save Account Settings
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Security Settings -->
                <div id="security" class="bg-white   shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Security Settings</h2>
                    
                    <div class="space-y-8">
                        <!-- Change Password -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Change Password</h3>
                            <form class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Current Password
                                    </label>
                                    <input type="password" 
                                           class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            New Password
                                        </label>
                                        <input type="password" 
                                               class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Confirm New Password
                                        </label>
                                        <input type="password" 
                                               class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                                
                                <div>
                                    <button type="submit" 
                                            class="bg-blue-600 text-white px-6 py-3   font-medium hover:bg-blue-700">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Two-Factor Authentication -->
                        <div class="pt-6 border-t">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Two-Factor Authentication</h3>
                            <div class="flex items-center justify-between p-4 border border-gray-300  ">
                                <div>
                                    <p class="font-medium text-gray-800">Two-Factor Authentication (2FA)</p>
                                    <p class="text-gray-600 text-sm">Add an extra layer of security to your account</p>
                                </div>
                                <button class="bg-blue-600 text-white px-6 py-2   hover:bg-blue-700 font-medium">
                                    Enable 2FA
                                </button>
                            </div>
                        </div>
                        
                        <!-- Login Activity -->
                        <div class="pt-6 border-t">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Login Activity</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 border border-gray-200  ">
                                    <div>
                                        <p class="font-medium text-gray-800">New York, USA</p>
                                        <p class="text-gray-600 text-sm">Chrome on Windows • Just now</p>
                                    </div>
                                    <span class="bg-green-100 text-green-800 px-3 py-1   text-sm">Current</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 border border-gray-200  ">
                                    <div>
                                        <p class="font-medium text-gray-800">London, UK</p>
                                        <p class="text-gray-600 text-sm">Safari on macOS • 2 days ago</p>
                                    </div>
                                    <button class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Revoke
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">
                                    View All Login Activity <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Account Deletion -->
                        <div class="pt-6 border-t">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Danger Zone</h3>
                            <div class="p-4 border border-red-300   bg-red-50">
                                <p class="font-medium text-red-800 mb-2">Delete Account</p>
                                <p class="text-red-700 text-sm mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                                <button type="button" 
                                        onclick="confirmAccountDeletion()"
                                        class="bg-red-600 text-white px-6 py-2   hover:bg-red-700 font-medium">
                                    Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Smooth scrolling for settings navigation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Account deletion confirmation
function confirmAccountDeletion() {
    if (confirm('Are you sure you want to delete your account? This action cannot be undone. All your data will be permanently removed.')) {
        // Here you would typically make an API call to delete the account
        alert('Account deletion request submitted. You will receive a confirmation email.');
    }
}

// Toggle switch styling
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        this.classList.toggle('checked:bg-blue-600');
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>