<?php
require_once 'includes/auth.php';
$auth = new Auth();

if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'recruiter') {
    header('Location: login.php');
    exit();
}

$userId = $auth->getUserId();

// Get company data from Firebase
require_once 'config/database.php';
$db = new Database();
$companyData = $db->getData('users/' . $userId);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $companyInfo = [
        'company_name' => $_POST['company_name'] ?? '',
        'company_size' => $_POST['company_size'] ?? '',
        'industry' => $_POST['industry'] ?? '',
        'website' => $_POST['website'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'email' => $_POST['email'] ?? '',
        'address' => $_POST['address'] ?? '',
        'city' => $_POST['city'] ?? '',
        'country' => $_POST['country'] ?? '',
        'about' => $_POST['about'] ?? '',
        'mission' => $_POST['mission'] ?? '',
        'culture' => $_POST['culture'] ?? '',
        'benefits' => $_POST['benefits'] ?? '',
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    // Social media links
    $socialLinks = [
        'linkedin' => $_POST['linkedin'] ?? '',
        'facebook' => $_POST['facebook'] ?? '',
        'twitter' => $_POST['twitter'] ?? '',
        'instagram' => $_POST['instagram'] ?? ''
    ];
    $companyInfo['social_links'] = $socialLinks;
    
    // Update in Firebase
    $result = $db->updateData('users/' . $userId, $companyInfo);
    
    if ($result) {
        $success = "Company profile updated successfully!";
        $companyData = array_merge($companyData, $companyInfo);
    } else {
        $error = "Failed to update company profile. Please try again.";
    }
}

$pageTitle = "Company Profile";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Company Profile</h1>
                    <p class="text-gray-600">Manage your company information and branding</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="dashboard.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-tachometer-alt mr-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <?php if (isset($success)): ?>
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo $success; ?></span>
        </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo $error; ?></span>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Sidebar -->
            <div class="lg:col-span-1">
                <!-- Company Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <div class="text-center">
                        <div class="w-32 h-32 bg-blue-600 rounded-lg flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-building text-white text-5xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 mb-2"><?php echo $companyData['company_name'] ?? 'Your Company'; ?></h2>
                        <p class="text-gray-600 mb-4"><?php echo $companyData['industry'] ?? 'Industry not set'; ?></p>
                        
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center justify-center text-gray-600">
                                <i class="fas fa-users mr-2"></i>
                                <span><?php echo $companyData['company_size'] ?? 'Size not set'; ?> employees</span>
                            </div>
                            <div class="flex items-center justify-center text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span><?php echo $companyData['city'] ?? 'Location not set'; ?></span>
                            </div>
                        </div>
                        
                        <div class="flex justify-center space-x-3">
                            <?php if (!empty($companyData['social_links']['linkedin'] ?? '')): ?>
                            <a href="<?php echo $companyData['social_links']['linkedin']; ?>" class="text-gray-400 hover:text-blue-700">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($companyData['social_links']['twitter'] ?? '')): ?>
                            <a href="<?php echo $companyData['social_links']['twitter']; ?>" class="text-gray-400 hover:text-blue-400">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($companyData['social_links']['facebook'] ?? '')): ?>
                            <a href="<?php echo $companyData['social_links']['facebook']; ?>" class="text-gray-400 hover:text-blue-600">
                                <i class="fab fa-facebook text-xl"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Profile Stats -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Company Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Active Jobs</span>
                            <span class="font-medium">12</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Applications</span>
                            <span class="font-medium">245</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Profile Views</span>
                            <span class="font-medium">1,245</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Member Since</span>
                            <span class="font-medium"><?php echo date('M Y', strtotime($companyData['created_at'] ?? 'now')); ?></span>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="font-medium text-gray-700 mb-3">Verification Status</h4>
                        <div class="flex items-center">
                            <div class="bg-green-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Email Verified</p>
                                <p class="text-gray-600 text-sm">✓ Company email verified</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <form method="POST" action="" class="space-y-8">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Basic Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Name *
                                </label>
                                <input type="text" 
                                       name="company_name" 
                                       value="<?php echo htmlspecialchars($companyData['company_name'] ?? ''); ?>"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Size *
                                </label>
                                <select name="company_size" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select company size</option>
                                    <option value="1-10" <?php echo ($companyData['company_size'] ?? '') === '1-10' ? 'selected' : ''; ?>>1-10 employees</option>
                                    <option value="11-50" <?php echo ($companyData['company_size'] ?? '') === '11-50' ? 'selected' : ''; ?>>11-50 employees</option>
                                    <option value="51-200" <?php echo ($companyData['company_size'] ?? '') === '51-200' ? 'selected' : ''; ?>>51-200 employees</option>
                                    <option value="201-500" <?php echo ($companyData['company_size'] ?? '') === '201-500' ? 'selected' : ''; ?>>201-500 employees</option>
                                    <option value="500+" <?php echo ($companyData['company_size'] ?? '') === '500+' ? 'selected' : ''; ?>>500+ employees</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Industry *
                                </label>
                                <select name="industry" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select Industry</option>
                                    <option value="airline" <?php echo ($companyData['industry'] ?? '') === 'airline' ? 'selected' : ''; ?>>Airline</option>
                                    <option value="hospitality" <?php echo ($companyData['industry'] ?? '') === 'hospitality' ? 'selected' : ''; ?>>Hospitality</option>
                                    <option value="aviation-services" <?php echo ($companyData['industry'] ?? '') === 'aviation-services' ? 'selected' : ''; ?>>Aviation Services</option>
                                    <option value="travel-tourism" <?php echo ($companyData['industry'] ?? '') === 'travel-tourism' ? 'selected' : ''; ?>>Travel & Tourism</option>
                                    <option value="airport-management" <?php echo ($companyData['industry'] ?? '') === 'airport-management' ? 'selected' : ''; ?>>Airport Management</option>
                                    <option value="other" <?php echo ($companyData['industry'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Website
                                </label>
                                <input type="url" 
                                       name="website" 
                                       value="<?php echo htmlspecialchars($companyData['website'] ?? ''); ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="https://example.com">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Contact Email *
                                </label>
                                <input type="email" 
                                       name="email" 
                                       value="<?php echo htmlspecialchars($companyData['email'] ?? ''); ?>"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number *
                                </label>
                                <input type="tel" 
                                       name="phone" 
                                       value="<?php echo htmlspecialchars($companyData['phone'] ?? ''); ?>"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Address
                                </label>
                                <input type="text" 
                                       name="address" 
                                       value="<?php echo htmlspecialchars($companyData['address'] ?? ''); ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        City
                                    </label>
                                    <input type="text" 
                                           name="city" 
                                           value="<?php echo htmlspecialchars($companyData['city'] ?? ''); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Country
                                    </label>
                                    <input type="text" 
                                           name="country" 
                                           value="<?php echo htmlspecialchars($companyData['country'] ?? ''); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Description -->
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Company Description</h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    About the Company *
                                </label>
                                <textarea name="about" 
                                          rows="4"
                                          required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Describe your company, history, and what you do"><?php echo htmlspecialchars($companyData['about'] ?? ''); ?></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Mission & Values
                                </label>
                                <textarea name="mission" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="What is your company's mission and core values?"><?php echo htmlspecialchars($companyData['mission'] ?? ''); ?></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Culture
                                </label>
                                <textarea name="culture" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Describe your company culture and work environment"><?php echo htmlspecialchars($companyData['culture'] ?? ''); ?></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Employee Benefits
                                </label>
                                <textarea name="benefits" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="List the benefits you offer to employees"><?php echo htmlspecialchars($companyData['benefits'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Social Media Links</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    LinkedIn
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 py-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 rounded-l-lg">
                                        <i class="fab fa-linkedin"></i>
                                    </span>
                                    <input type="url" 
                                           name="linkedin" 
                                           value="<?php echo htmlspecialchars($companyData['social_links']['linkedin'] ?? ''); ?>"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="https://linkedin.com/company/your-company">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Twitter
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 py-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 rounded-l-lg">
                                        <i class="fab fa-twitter"></i>
                                    </span>
                                    <input type="url" 
                                           name="twitter" 
                                           value="<?php echo htmlspecialchars($companyData['social_links']['twitter'] ?? ''); ?>"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="https://twitter.com/yourcompany">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Facebook
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 py-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 rounded-l-lg">
                                        <i class="fab fa-facebook"></i>
                                    </span>
                                    <input type="url" 
                                           name="facebook" 
                                           value="<?php echo htmlspecialchars($companyData['social_links']['facebook'] ?? ''); ?>"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="https://facebook.com/yourcompany">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Instagram
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 py-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 rounded-l-lg">
                                        <i class="fab fa-instagram"></i>
                                    </span>
                                    <input type="url" 
                                           name="instagram" 
                                           value="<?php echo htmlspecialchars($companyData['social_links']['instagram'] ?? ''); ?>"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="https://instagram.com/yourcompany">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Logo -->
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Company Logo & Branding</h2>
                        
                        <div class="flex flex-col md:flex-row items-start md:items-center">
                            <div class="mb-6 md:mb-0 md:mr-8">
                                <div class="w-48 h-48 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-building text-blue-600 text-6xl"></i>
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-800 mb-4">Upload Company Logo</h3>
                                <p class="text-gray-600 mb-6">
                                    Upload your company logo in PNG or JPG format. Recommended size: 400×400 pixels. Max file size: 5MB.
                                </p>
                                
                                <div class="flex space-x-4">
                                    <label class="cursor-pointer bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-medium">
                                        <i class="fas fa-upload mr-2"></i>Upload Logo
                                        <input type="file" accept="image/*" class="hidden" id="logoUpload">
                                    </label>
                                    <button type="button" class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 font-medium">
                                        Remove Logo
                                    </button>
                                </div>
                                
                                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex items-start">
                                        <i class="fas fa-lightbulb text-yellow-600 text-xl mr-3 mt-1"></i>
                                        <div>
                                            <p class="font-medium text-yellow-800 mb-1">Logo Guidelines</p>
                                            <ul class="text-yellow-700 text-sm space-y-1">
                                                <li>• Use a high-resolution logo for best quality</li>
                                                <li>• Ensure logo is centered and clearly visible</li>
                                                <li>• Transparent background (PNG) is recommended</li>
                                                <li>• File formats: PNG, JPG, SVG</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-medium hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Logo upload preview
document.getElementById('logoUpload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const logoContainer = document.querySelector('.bg-blue-100');
            logoContainer.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain rounded-xl" alt="Company Logo">`;
        };
        reader.readAsDataURL(file);
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(event) {
    const companyName = document.querySelector('input[name="company_name"]');
    const companySize = document.querySelector('select[name="company_size"]');
    const industry = document.querySelector('select[name="industry"]');
    
    if (!companyName.value.trim()) {
        alert('Company name is required');
        companyName.focus();
        event.preventDefault();
        return false;
    }
    
    if (!companySize.value) {
        alert('Company size is required');
        companySize.focus();
        event.preventDefault();
        return false;
    }
    
    if (!industry.value) {
        alert('Industry is required');
        industry.focus();
        event.preventDefault();
        return false;
    }
    
    return true;
});
</script>

<?php require_once 'includes/footer.php'; ?>