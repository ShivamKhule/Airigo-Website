<?php
require_once 'includes/auth.php';
$auth = new Auth();

if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'recruiter') {
    header('Location: login.php');
    exit();
}

$userId = $auth->getUserId();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config/database.php';
    $db = new Database();
    
    $jobData = [
        'recruiter_id' => $userId,
        'title' => $_POST['title'] ?? '',
        'company' => $_POST['company'] ?? '',
        'location' => $_POST['location'] ?? '',
        'job_type' => $_POST['job_type'] ?? '',
        'salary_min' => $_POST['salary_min'] ?? '',
        'salary_max' => $_POST['salary_max'] ?? '',
        'salary_type' => $_POST['salary_type'] ?? 'yearly',
        'experience_min' => $_POST['experience_min'] ?? '',
        'experience_max' => $_POST['experience_max'] ?? '',
        'education' => $_POST['education'] ?? '',
        'description' => $_POST['description'] ?? '',
        'requirements' => $_POST['requirements'] ?? '',
        'benefits' => $_POST['benefits'] ?? '',
        'skills' => explode(',', $_POST['skills'] ?? ''),
        'category' => $_POST['category'] ?? '',
        'deadline' => $_POST['deadline'] ?? '',
        'urgent' => isset($_POST['urgent']) ? true : false,
        'remote' => isset($_POST['remote']) ? true : false,
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'applications' => 0,
        'views' => 0
    ];
    
    // Save to Firebase
    $result = $db->pushData('jobs', $jobData);
    
    if ($result) {
        $success = "Job posted successfully!";
        // Clear form or redirect
    } else {
        $error = "Failed to post job. Please try again.";
    }
}

$pageTitle = "Post a Job";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Post a New Job</h1>
            <p class="text-gray-600">Fill in the details below to post your job vacancy</p>
        </div>
        
        <?php if (isset($success)): ?>
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3   relative" role="alert">
            <span class="block sm:inline"><?php echo $success; ?></span>
            <a href="manage-jobs.php" class="font-bold underline ml-2">View your jobs</a>
        </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3   relative" role="alert">
            <span class="block sm:inline"><?php echo $error; ?></span>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="space-y-8">
            <!-- Basic Information -->
            <div class="bg-white   shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Basic Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Job Title *
                        </label>
                        <input type="text" 
                               name="title" 
                               required
                               class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., Senior Pilot, Flight Attendant">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company Name *
                        </label>
                        <input type="text" 
                               name="company" 
                               required
                               class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Your company name">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Job Category *
                        </label>
                        <select name="category" 
                                required
                                class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Category</option>
                            <option value="airline">Airline Jobs</option>
                            <option value="hospitality">Hospitality</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="management">Management</option>
                            <option value="customer-service">Customer Service</option>
                            <option value="security">Security</option>
                            <option value="food-service">Food Service</option>
                            <option value="sales-marketing">Sales & Marketing</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Job Type *
                        </label>
                        <select name="job_type" 
                                required
                                class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Job Type</option>
                            <option value="full-time">Full-time</option>
                            <option value="part-time">Part-time</option>
                            <option value="contract">Contract</option>
                            <option value="internship">Internship</option>
                            <option value="temporary">Temporary</option>
                            <option value="remote">Remote</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Location *
                        </label>
                        <input type="text" 
                               name="location" 
                               required
                               class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., New York, USA or Remote">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Application Deadline *
                        </label>
                        <input type="date" 
                               name="deadline" 
                               required
                               min="<?php echo date('Y-m-d'); ?>"
                               class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <!-- Checkboxes -->
                <div class="mt-6 flex space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="urgent"
                               class="h-4 w-4 text-blue-600  ">
                        <span class="ml-2 text-gray-700">Urgent Hiring</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="remote"
                               class="h-4 w-4 text-blue-600  ">
                        <span class="ml-2 text-gray-700">Remote Position</span>
                    </label>
                </div>
            </div>
            
            <!-- Salary Information -->
            <div class="bg-white   shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Salary & Compensation</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Minimum Salary
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">$</span>
                            <input type="number" 
                                   name="salary_min" 
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="e.g., 50000">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Maximum Salary
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">$</span>
                            <input type="number" 
                                   name="salary_max" 
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="e.g., 100000">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Salary Type
                        </label>
                        <select name="salary_type" 
                                class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="yearly">Per Year</option>
                            <option value="monthly">Per Month</option>
                            <option value="weekly">Per Week</option>
                            <option value="hourly">Per Hour</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Requirements -->
            <div class="bg-white   shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Requirements & Qualifications</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Minimum Experience (years)
                        </label>
                        <input type="number" 
                               name="experience_min" 
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., 3">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Maximum Experience (years)
                        </label>
                        <input type="number" 
                               name="experience_max" 
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., 10">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Education Level
                        </label>
                        <select name="education" 
                                class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Any Education</option>
                            <option value="high-school">High School</option>
                            <option value="associate">Associate Degree</option>
                            <option value="bachelor">Bachelor's Degree</option>
                            <option value="master">Master's Degree</option>
                            <option value="phd">PhD</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Required Skills (Separate with commas)
                    </label>
                    <input type="text" 
                           name="skills" 
                           class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="e.g., Leadership, Communication, Project Management">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Job Requirements *
                    </label>
                    <textarea name="requirements" 
                              rows="6"
                              required
                              class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="List the specific requirements for this position"></textarea>
                </div>
            </div>
            
            <!-- Job Description -->
            <div class="bg-white   shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Job Description</h2>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Detailed Job Description *
                    </label>
                    <textarea name="description" 
                              rows="8"
                              required
                              class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Describe the job responsibilities, day-to-day tasks, and what makes this position exciting"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Benefits & Perks
                    </label>
                    <textarea name="benefits" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="List the benefits and perks offered with this position"></textarea>
                </div>
            </div>
            
            <!-- Preview & Submit -->
            <div class="bg-white   shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Preview & Submit</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Job Preview -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Job Preview</h3>
                        <div class="border border-gray-200   p-6">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 bg-blue-100   flex items-center justify-center mr-4">
                                    <i class="fas fa-briefcase text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800" id="preview-title">Job Title</h4>
                                    <p class="text-gray-600" id="preview-company">Company Name</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-3 text-blue-500"></i>
                                    <span id="preview-location">Location</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-briefcase mr-3 text-blue-500"></i>
                                    <span id="preview-type">Job Type</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-money-bill-wave mr-3 text-blue-500"></i>
                                    <span id="preview-salary">Salary</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submission Options -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Submission Options</h3>
                        <div class="space-y-4">
                            <label class="flex items-start p-4 border border-gray-200   hover:border-blue-500 cursor-pointer">
                                <input type="radio" name="publish_option" value="publish" checked class="mt-1 mr-3">
                                <div>
                                    <p class="font-medium text-gray-800">Publish Immediately</p>
                                    <p class="text-gray-600 text-sm">Your job will be visible to all job seekers right away</p>
                                </div>
                            </label>
                            
                            <label class="flex items-start p-4 border border-gray-200   hover:border-blue-500 cursor-pointer">
                                <input type="radio" name="publish_option" value="draft" class="mt-1 mr-3">
                                <div>
                                    <p class="font-medium text-gray-800">Save as Draft</p>
                                    <p class="text-gray-600 text-sm">Save your job posting and publish it later</p>
                                </div>
                            </label>
                            
                            <label class="flex items-start p-4 border border-gray-200   hover:border-blue-500 cursor-pointer">
                                <input type="radio" name="publish_option" value="schedule" class="mt-1 mr-3">
                                <div>
                                    <p class="font-medium text-gray-800">Schedule for Later</p>
                                    <p class="text-gray-600 text-sm">Set a specific date and time to publish</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Terms and Submit -->
                <div class="mt-8 pt-8 border-t">
                    <div class="flex items-start mb-6">
                        <input type="checkbox" 
                               id="terms" 
                               required
                               class="mt-1 mr-3 h-4 w-4 text-blue-600  ">
                        <label for="terms" class="text-gray-700">
                            I confirm that this job posting complies with all applicable laws and regulations. I understand that misrepresentation may result in account suspension.
                        </label>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <button type="button" class="border border-gray-300 text-gray-700 px-8 py-3   font-medium hover:bg-gray-50">
                            Save Draft
                        </button>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3   font-medium hover:bg-blue-700">
                            <i class="fas fa-paper-plane mr-2"></i>Publish Job
                        </button>
                    </div>
                </div>
            </div>
        </form>
        
        <!-- Pricing Information -->
        <div class="mt-8 bg-gradient-to-r from-blue-500 to-blue-700   p-8 text-white">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2">Premium Job Posting</h3>
                    <p class="text-blue-100">Get 3x more applications with our premium features</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="#" class="bg-white text-blue-600 px-8 py-3   font-bold hover:bg-gray-100 transition duration-300">
                        <i class="fas fa-crown mr-2"></i>Upgrade Now
                    </a>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center">
                    <i class="fas fa-bolt text-xl mr-3"></i>
                    <span>Urgent Hiring Badge</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-star text-xl mr-3"></i>
                    <span>Featured Listing</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-chart-line text-xl mr-3"></i>
                    <span>Priority Placement</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview update
function updatePreview() {
    const title = document.querySelector('input[name="title"]')?.value || 'Job Title';
    const company = document.querySelector('input[name="company"]')?.value || 'Company Name';
    const location = document.querySelector('input[name="location"]')?.value || 'Location';
    const jobType = document.querySelector('select[name="job_type"]')?.value || 'Job Type';
    const salaryMin = document.querySelector('input[name="salary_min"]')?.value || '';
    const salaryMax = document.querySelector('input[name="salary_max"]')?.value || '';
    const salaryType = document.querySelector('select[name="salary_type"]')?.value || 'yearly';
    
    document.getElementById('preview-title').textContent = title;
    document.getElementById('preview-company').textContent = company;
    document.getElementById('preview-location').textContent = location;
    document.getElementById('preview-type').textContent = jobType.charAt(0).toUpperCase() + jobType.slice(1);
    
    let salaryText = 'Salary not specified';
    if (salaryMin || salaryMax) {
        const salaryPrefix = salaryType === 'yearly' ? '$' : '';
        const salarySuffix = salaryType === 'yearly' ? '/year' : 
                            salaryType === 'monthly' ? '/month' :
                            salaryType === 'weekly' ? '/week' : '/hour';
        
        if (salaryMin && salaryMax) {
            salaryText = `${salaryPrefix}${salaryMin} - ${salaryPrefix}${salaryMax}${salarySuffix}`;
        } else if (salaryMin) {
            salaryText = `From ${salaryPrefix}${salaryMin}${salarySuffix}`;
        } else if (salaryMax) {
            salaryText = `Up to ${salaryPrefix}${salaryMax}${salarySuffix}`;
        }
    }
    document.getElementById('preview-salary').textContent = salaryText;
}

// Attach event listeners to form inputs
document.querySelectorAll('input, select').forEach(input => {
    input.addEventListener('input', updatePreview);
    input.addEventListener('change', updatePreview);
});

// Initial preview update
updatePreview();
</script>

<?php require_once 'includes/footer.php'; ?>