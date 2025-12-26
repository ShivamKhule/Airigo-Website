<?php
require_once 'includes/auth.php';
$auth = new Auth();

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$userId = $auth->getUserId();
$userRole = $auth->getUserRole();

// Get user data from Firebase
require_once 'config/database.php';
$db = new Database();
$userData = $db->getData('users/' . $userId);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profileData = [
        'full_name' => $_POST['full_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'location' => $_POST['location'] ?? '',
        'title' => $_POST['title'] ?? '',
        'bio' => $_POST['bio'] ?? '',
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    if ($userRole === 'jobseeker') {
        $profileData['experience_years'] = $_POST['experience_years'] ?? '';
        $profileData['education'] = $_POST['education'] ?? '';
        $profileData['skills'] = explode(',', $_POST['skills'] ?? '');
        $profileData['expected_salary'] = $_POST['expected_salary'] ?? '';
        $profileData['preferred_job_types'] = $_POST['preferred_job_types'] ?? [];
        $profileData['profile_complete_percentage'] = 85;
    } else {
        $profileData['company_name'] = $_POST['company_name'] ?? '';
        $profileData['company_size'] = $_POST['company_size'] ?? '';
        $profileData['company_website'] = $_POST['company_website'] ?? '';
        $profileData['company_description'] = $_POST['company_description'] ?? '';
    }
    
    // Update in Firebase
    $result = $db->updateData('users/' . $userId, $profileData);
    
    if ($result) {
        $success = "Profile updated successfully!";
        $userData = array_merge($userData, $profileData);
    } else {
        $error = "Failed to update profile. Please try again.";
    }
}

$pageTitle = "Profile Management";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile Management</h1>
            <p class="text-gray-600">Update your personal and professional information</p>
        </div>
        
        <?php if (isset($success)): ?>
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3   relative" role="alert">
            <span class="block sm:inline"><?php echo $success; ?></span>
        </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3   relative" role="alert">
            <span class="block sm:inline"><?php echo $error; ?></span>
        </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white   shadow-lg p-6 sticky top-8">
                    <!-- Profile Completion -->
                    <div class="mb-8">
                        <h3 class="font-bold text-gray-800 mb-4">Profile Completion</h3>
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span><?php echo $userData['profile_complete_percentage'] ?? 60; ?>% Complete</span>
                                <span><?php echo $userData['profile_complete_percentage'] ?? 60; ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200   h-2">
                                <div class="bg-blue-600 h-2  " style="width: <?php echo $userData['profile_complete_percentage'] ?? 60; ?>%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="space-y-2">
                        <a href="#personal" class="block px-4 py-3   bg-blue-50 text-blue-600 font-medium">
                            <i class="fas fa-user mr-2"></i>Personal Information
                        </a>
                        <?php if ($userRole === 'jobseeker'): ?>
                        <a href="#professional" class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-briefcase mr-2"></i>Professional Info
                        </a>
                        <a href="#education" class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-graduation-cap mr-2"></i>Education
                        </a>
                        <a href="#skills" class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-star mr-2"></i>Skills
                        </a>
                        <a href="#preferences" class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-sliders-h mr-2"></i>Job Preferences
                        </a>
                        <?php else: ?>
                        <a href="#company" class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-building mr-2"></i>Company Information
                        </a>
                        <?php endif; ?>
                        <a href="#resume" class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-file-alt mr-2"></i>Resume/CV
                        </a>
                        <a href="#security" class="block px-4 py-3   text-gray-700 hover:bg-gray-100 font-medium">
                            <i class="fas fa-shield-alt mr-2"></i>Security
                        </a>
                    </nav>
                    
                    <!-- Profile Stats -->
                    <div class="mt-8 pt-8 border-t">
                        <h3 class="font-bold text-gray-800 mb-4">Profile Stats</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Profile Views</span>
                                <span class="font-medium">156</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Applications</span>
                                <span class="font-medium">24</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Saved Jobs</span>
                                <span class="font-medium">8</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Updated</span>
                                <span class="font-medium">Today</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <form method="POST" action="" class="space-y-8">
                    <!-- Personal Information -->
                    <div id="personal" class="bg-white   shadow-lg p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Personal Information</h2>
                            <span class="text-green-600 font-medium">✓ Completed</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name *
                                </label>
                                <input type="text" 
                                       name="full_name" 
                                       value="<?php echo htmlspecialchars($userData['full_name'] ?? ''); ?>"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
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
                                    Location *
                                </label>
                                <input type="text" 
                                       name="location" 
                                       value="<?php echo htmlspecialchars($userData['location'] ?? ''); ?>"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="City, Country">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Professional Title
                                </label>
                                <input type="text" 
                                       name="title" 
                                       value="<?php echo htmlspecialchars($userData['title'] ?? ''); ?>"
                                       class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g., Senior Pilot, HR Manager">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Professional Bio
                                </label>
                                <textarea name="bio" 
                                          rows="4"
                                          class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Tell us about your professional background and experience"><?php echo htmlspecialchars($userData['bio'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        
                        <!-- Profile Picture -->
                        <div class="mt-8 pt-8 border-t">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Profile Picture</h3>
                            <div class="flex items-center">
                                <div class="w-32 h-32 bg-blue-100   flex items-center justify-center mr-6">
                                    <span class="text-4xl font-bold text-blue-600">
                                        <?php echo substr($userData['full_name'] ?? 'U', 0, 1); ?>
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-600 mb-4">Upload a professional profile picture (Max 5MB)</p>
                                    <div class="flex space-x-3">
                                        <label class="cursor-pointer bg-blue-600 text-white px-6 py-3   hover:bg-blue-700 font-medium">
                                            <i class="fas fa-upload mr-2"></i>Upload Photo
                                            <input type="file" accept="image/*" class="hidden">
                                        </label>
                                        <button type="button" class="border border-gray-300 text-gray-700 px-6 py-3   hover:bg-gray-50 font-medium">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($userRole === 'jobseeker'): ?>
                    <!-- Professional Information -->
                    <div id="professional" class="bg-white   shadow-lg p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Professional Information</h2>
                            <span class="text-yellow-600 font-medium">⚡ In Progress</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Years of Experience *
                                </label>
                                <select name="experience_years" 
                                        class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select Experience</option>
                                    <option value="0-1" <?php echo ($userData['experience_years'] ?? '') === '0-1' ? 'selected' : ''; ?>>0-1 years</option>
                                    <option value="1-3" <?php echo ($userData['experience_years'] ?? '') === '1-3' ? 'selected' : ''; ?>>1-3 years</option>
                                    <option value="3-5" <?php echo ($userData['experience_years'] ?? '') === '3-5' ? 'selected' : ''; ?>>3-5 years</option>
                                    <option value="5-10" <?php echo ($userData['experience_years'] ?? '') === '5-10' ? 'selected' : ''; ?>>5-10 years</option>
                                    <option value="10+" <?php echo ($userData['experience_years'] ?? '') === '10+' ? 'selected' : ''; ?>>10+ years</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Expected Salary (Annual)
                                </label>
                                <input type="text" 
                                       name="expected_salary" 
                                       value="<?php echo htmlspecialchars($userData['expected_salary'] ?? ''); ?>"
                                       class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g., $80,000 - $120,000">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Education -->
                    <div id="education" class="bg-white   shadow-lg p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Education</h2>
                            <span class="text-yellow-600 font-medium">⚡ In Progress</span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Highest Education Level *
                            </label>
                            <select name="education" 
                                    class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Education Level</option>
                                <option value="high-school" <?php echo ($userData['education'] ?? '') === 'high-school' ? 'selected' : ''; ?>>High School</option>
                                <option value="associate" <?php echo ($userData['education'] ?? '') === 'associate' ? 'selected' : ''; ?>>Associate Degree</option>
                                <option value="bachelor" <?php echo ($userData['education'] ?? '') === 'bachelor' ? 'selected' : ''; ?>>Bachelor's Degree</option>
                                <option value="master" <?php echo ($userData['education'] ?? '') === 'master' ? 'selected' : ''; ?>>Master's Degree</option>
                                <option value="phd" <?php echo ($userData['education'] ?? '') === 'phd' ? 'selected' : ''; ?>>PhD</option>
                                <option value="other" <?php echo ($userData['education'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        
                        <!-- Add Education Button -->
                        <div class="mt-6">
                            <button type="button" class="flex items-center text-blue-600 hover:text-blue-700 font-medium">
                                <i class="fas fa-plus mr-2"></i>Add Education Details
                            </button>
                        </div>
                    </div>
                    
                    <!-- Skills -->
                    <div id="skills" class="bg-white   shadow-lg p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Skills & Expertise</h2>
                            <span class="text-yellow-600 font-medium">⚡ In Progress</span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Your Skills (Separate with commas)
                            </label>
                            <input type="text" 
                                   name="skills" 
                                   value="<?php echo htmlspecialchars(implode(', ', $userData['skills'] ?? [])); ?>"
                                   class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="e.g., Leadership, Communication, Project Management">
                            <p class="mt-2 text-sm text-gray-500">Add relevant skills to help employers find you</p>
                        </div>
                        
                        <!-- Popular Skills -->
                        <div class="mt-6">
                            <p class="text-sm font-medium text-gray-700 mb-3">Popular Skills in Airline:</p>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" class="skill-tag bg-gray-100 text-gray-700 px-3 py-1   text-sm hover:bg-gray-200">
                                    Airline Safety
                                </button>
                                <button type="button" class="skill-tag bg-gray-100 text-gray-700 px-3 py-1   text-sm hover:bg-gray-200">
                                    Crew Resource Management
                                </button>
                                <button type="button" class="skill-tag bg-gray-100 text-gray-700 px-3 py-1   text-sm hover:bg-gray-200">
                                    Flight Operations
                                </button>
                                <button type="button" class="skill-tag bg-gray-100 text-gray-700 px-3 py-1   text-sm hover:bg-gray-200">
                                    Navigation
                                </button>
                                <button type="button" class="skill-tag bg-gray-100 text-gray-700 px-3 py-1   text-sm hover:bg-gray-200">
                                    Customer Service
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Job Preferences -->
                    <div id="preferences" class="bg-white   shadow-lg p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Job Preferences</h2>
                            <span class="text-gray-400 font-medium">○ Not Started</span>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Preferred Job Types
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <?php
                                    $jobTypes = [
                                        'full-time' => 'Full-time',
                                        'part-time' => 'Part-time',
                                        'contract' => 'Contract',
                                        'internship' => 'Internship',
                                        'remote' => 'Remote',
                                        'temporary' => 'Temporary'
                                    ];
                                    
                                    foreach ($jobTypes as $value => $label):
                                        $checked = in_array($value, $userData['preferred_job_types'] ?? []) ? 'checked' : '';
                                    ?>
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="preferred_job_types[]" 
                                               value="<?php echo $value; ?>"
                                               <?php echo $checked; ?>
                                               class="h-4 w-4 text-blue-600  ">
                                        <span class="ml-2 text-gray-700"><?php echo $label; ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Preferred Locations
                                </label>
                                <input type="text" 
                                       class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Add preferred locations (e.g., New York, London, Dubai)">
                            </div>
                        </div>
                    </div>
                    
                    <?php else: ?>
                    <!-- Company Information -->
                    <div id="company" class="bg-white   shadow-lg p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Company Information</h2>
                            <span class="text-yellow-600 font-medium">⚡ In Progress</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Name *
                                </label>
                                <input type="text" 
                                       name="company_name" 
                                       value="<?php echo htmlspecialchars($userData['company_name'] ?? ''); ?>"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Size
                                </label>
                                <select name="company_size" 
                                        class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select company size</option>
                                    <option value="1-10" <?php echo ($userData['company_size'] ?? '') === '1-10' ? 'selected' : ''; ?>>1-10 employees</option>
                                    <option value="11-50" <?php echo ($userData['company_size'] ?? '') === '11-50' ? 'selected' : ''; ?>>11-50 employees</option>
                                    <option value="51-200" <?php echo ($userData['company_size'] ?? '') === '51-200' ? 'selected' : ''; ?>>51-200 employees</option>
                                    <option value="201-500" <?php echo ($userData['company_size'] ?? '') === '201-500' ? 'selected' : ''; ?>>201-500 employees</option>
                                    <option value="500+" <?php echo ($userData['company_size'] ?? '') === '500+' ? 'selected' : ''; ?>>500+ employees</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Website
                                </label>
                                <input type="url" 
                                       name="company_website" 
                                       value="<?php echo htmlspecialchars($userData['company_website'] ?? ''); ?>"
                                       class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="https://example.com">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Industry
                                </label>
                                <select class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select Industry</option>
                                    <option value="airline">Airline</option>
                                    <option value="hospitality">Hospitality</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Description
                                </label>
                                <textarea name="company_description" 
                                          rows="4"
                                          class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Tell us about your company"><?php echo htmlspecialchars($userData['company_description'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        
                        <!-- Company Logo -->
                        <div class="mt-8 pt-8 border-t">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Company Logo</h3>
                            <div class="flex items-center">
                                <div class="w-32 h-32 bg-blue-100   flex items-center justify-center mr-6">
                                    <i class="fas fa-building text-4xl text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-gray-600 mb-4">Upload your company logo (Max 5MB, JPG/PNG)</p>
                                    <div class="flex space-x-3">
                                        <label class="cursor-pointer bg-blue-600 text-white px-6 py-3   hover:bg-blue-700 font-medium">
                                            <i class="fas fa-upload mr-2"></i>Upload Logo
                                            <input type="file" accept="image/*" class="hidden">
                                        </label>
                                        <button type="button" class="border border-gray-300 text-gray-700 px-6 py-3   hover:bg-gray-50 font-medium">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Resume/CV -->
                    <div id="resume" class="bg-white   shadow-lg p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Resume/CV</h2>
                            <span class="text-gray-400 font-medium">○ Not Started</span>
                        </div>
                        
                        <?php if ($userRole === 'jobseeker'): ?>
                        <div class="border-2 border-dashed border-gray-300   p-8 text-center">
                            <i class="fas fa-file-upload text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Upload Your Resume</h3>
                            <p class="text-gray-600 mb-6">Upload your resume in PDF, DOC, or DOCX format (Max 10MB)</p>
                            <label class="cursor-pointer bg-blue-600 text-white px-8 py-3   hover:bg-blue-700 font-medium inline-block">
                                <i class="fas fa-upload mr-2"></i>Choose File
                                <input type="file" accept=".pdf,.doc,.docx" class="hidden">
                            </label>
                        </div>
                        
                        <!-- Resume Status -->
                        <div class="mt-6 p-4 bg-blue-50  ">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-600 text-xl mr-3"></i>
                                <div>
                                    <p class="text-blue-800 font-medium">Your profile is 85% complete</p>
                                    <p class="text-blue-600 text-sm">Uploading a resume increases your profile completion and chances of getting hired.</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Security -->
                    <div id="security" class="bg-white   shadow-lg p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Security Settings</h2>
                            <span class="text-yellow-600 font-medium">⚡ In Progress</span>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 mb-4">Change Password</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Current Password
                                        </label>
                                        <input type="password" 
                                               class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
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
                                    <div class="flex items-end">
                                        <button type="button" class="bg-blue-600 text-white px-6 py-3   hover:bg-blue-700 font-medium">
                                            Update Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t">
                                <h3 class="text-lg font-bold text-gray-800 mb-4">Privacy Settings</h3>
                                <div class="space-y-4">
                                    <label class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-800">Make Profile Public</p>
                                            <p class="text-gray-600 text-sm">Allow employers to view your profile</p>
                                        </div>
                                        <input type="checkbox" class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                    </label>
                                    <label class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-800">Email Notifications</p>
                                            <p class="text-gray-600 text-sm">Receive job alerts and updates</p>
                                        </div>
                                        <input type="checkbox" class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600" checked>
                                    </label>
                                    <label class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-800">SMS Notifications</p>
                                            <p class="text-gray-600 text-sm">Receive text message alerts</p>
                                        </div>
                                        <input type="checkbox" class="relative h-6 w-11   bg-gray-200 checked:bg-blue-600">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Save Changes Button -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" class="border border-gray-300 text-gray-700 px-8 py-3   font-medium hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3   font-medium hover:bg-blue-700">
                            Save All Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Skill tag selection
document.querySelectorAll('.skill-tag').forEach(tag => {
    tag.addEventListener('click', function() {
        const skillInput = document.querySelector('input[name="skills"]');
        const currentSkills = skillInput.value ? skillInput.value.split(', ') : [];
        const skill = this.textContent.trim();
        
        if (!currentSkills.includes(skill)) {
            currentSkills.push(skill);
            skillInput.value = currentSkills.join(', ');
        }
    });
});

// Smooth scrolling for navigation
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
</script>

<?php require_once 'includes/footer.php'; ?>