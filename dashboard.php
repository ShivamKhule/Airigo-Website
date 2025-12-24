<?php
require_once 'includes/auth.php';
$auth = new Auth();

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$userRole = $auth->getUserRole();
$userId = $auth->getUserId();

// Get user data from Firebase
require_once 'config/database.php';
$db = new Database();
$userData = $db->getData('users/' . $userId);

$pageTitle = "Dashboard";
require_once 'includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-8 text-white mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome back, <?php echo $userData['full_name'] ?? 'User'; ?>!</h1>
                <p class="text-blue-100">
                    <?php if ($userRole === 'jobseeker'): ?>
                    Your job search journey continues. Check out new opportunities today.
                    <?php else: ?>
                    Manage your job postings and candidates efficiently.
                    <?php endif; ?>
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <?php if ($userRole === 'jobseeker'): ?>
                <a href="profile.php" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    <i class="fas fa-edit mr-2"></i>Update Profile
                </a>
                <?php else: ?>
                <a href="post-job.php" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Post New Job
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php if ($userRole === 'jobseeker'): ?>
    <!-- Job Seeker Dashboard -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Stats & Quick Actions -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-paper-plane text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Applications</p>
                            <p class="text-2xl font-bold text-gray-800">24</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="applications.php" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-eye text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Profile Views</p>
                            <p class="text-2xl font-bold text-gray-800">156</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="profile.php" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            View Profile <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-heart text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Saved Jobs</p>
                            <p class="text-2xl font-bold text-gray-800">8</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="saved-jobs.php" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            View Saved <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Application Status -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Application Status</h2>
                <div class="space-y-4">
                    <?php
                    $applications = [
                        ['company' => 'Airigo Airlines', 'position' => 'Senior Pilot', 'status' => 'Shortlisted', 'date' => '2024-01-15', 'color' => 'bg-green-100 text-green-800'],
                        ['company' => 'SkyJet Airways', 'position' => 'Flight Attendant', 'status' => 'Pending', 'date' => '2024-01-14', 'color' => 'bg-yellow-100 text-yellow-800'],
                        ['company' => 'Global Airports', 'position' => 'Airport Manager', 'status' => 'Applied', 'date' => '2024-01-12', 'color' => 'bg-blue-100 text-blue-800'],
                        ['company' => 'Hospitality Plus', 'position' => 'Hotel Manager', 'status' => 'Rejected', 'date' => '2024-01-10', 'color' => 'bg-red-100 text-red-800'],
                    ];
                    
                    foreach ($applications as $app):
                    ?>
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-building text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800"><?php echo $app['position']; ?></h3>
                                <p class="text-gray-600 text-sm"><?php echo $app['company']; ?></p>
                                <p class="text-gray-500 text-xs">Applied on <?php echo date('M d, Y', strtotime($app['date'])); ?></p>
                            </div>
                        </div>
                        <span class="<?php echo $app['color']; ?> px-3 py-1 rounded-full text-sm font-medium">
                            <?php echo $app['status']; ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-6 text-center">
                    <a href="applications.php" class="text-blue-600 hover:text-blue-700 font-medium">
                        View All Applications <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Recommended Jobs -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Recommended For You</h2>
                    <a href="job-search.php" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        See All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php
                    $recommendedJobs = [
                        ['title' => 'Aircraft Maintenance Engineer', 'company' => 'Airigo Airlines', 'location' => 'New York', 'salary' => '$75,000 - $95,000'],
                        ['title' => 'Customer Service Agent', 'company' => 'SkyJet Airways', 'location' => 'London', 'salary' => '$35,000 - $45,000'],
                        ['title' => 'Air Traffic Controller', 'company' => 'Global Airports', 'location' => 'Dubai', 'salary' => '$90,000 - $120,000'],
                        ['title' => 'Hospitality Manager', 'company' => 'Luxury Hotels', 'location' => 'Miami', 'salary' => '$60,000 - $80,000'],
                    ];
                    
                    foreach ($recommendedJobs as $job):
                    ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 hover:shadow-md transition duration-300">
                        <h3 class="font-bold text-gray-800 mb-2"><?php echo $job['title']; ?></h3>
                        <p class="text-gray-600 text-sm mb-2"><?php echo $job['company']; ?></p>
                        <div class="flex items-center text-gray-500 text-sm mb-3">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span class="mr-4"><?php echo $job['location']; ?></span>
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            <span><?php echo $job['salary']; ?></span>
                        </div>
                        <a href="job-details.php" class="block w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                            Apply Now
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Profile & Quick Links -->
        <div class="space-y-8">
            <!-- Profile Summary -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                        <?php echo substr($userData['full_name'] ?? 'U', 0, 1); ?>
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-800 text-lg"><?php echo $userData['full_name'] ?? 'User'; ?></h2>
                        <p class="text-gray-600 text-sm"><?php echo $userData['title'] ?? 'Job Seeker'; ?></p>
                        <p class="text-gray-500 text-xs">Member since <?php echo date('M Y', strtotime($userData['created_at'] ?? 'now')); ?></p>
                    </div>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-envelope mr-3 text-blue-500"></i>
                        <span class="text-sm"><?php echo $userData['email'] ?? 'Not set'; ?></span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-phone mr-3 text-blue-500"></i>
                        <span class="text-sm"><?php echo $userData['phone'] ?? 'Not set'; ?></span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-map-marker-alt mr-3 text-blue-500"></i>
                        <span class="text-sm"><?php echo $userData['location'] ?? 'Location not set'; ?></span>
                    </div>
                </div>
                
                <div class="pt-4 border-t">
                    <a href="profile.php" class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 font-medium transition duration-300">
                        <i class="fas fa-edit mr-2"></i>Complete Your Profile
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Links</h2>
                <div class="space-y-3">
                    <a href="job-search.php" class="flex items-center p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                        <div class="bg-blue-100 w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-search text-blue-600"></i>
                        </div>
                        <span class="font-medium">Search Jobs</span>
                    </a>
                    
                    <a href="saved-jobs.php" class="flex items-center p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                        <div class="bg-blue-100 w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-heart text-blue-600"></i>
                        </div>
                        <span class="font-medium">Saved Jobs</span>
                    </a>
                    
                    <a href="applications.php" class="flex items-center p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                        <div class="bg-blue-100 w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-paper-plane text-blue-600"></i>
                        </div>
                        <span class="font-medium">My Applications</span>
                    </a>
                    
                    <a href="profile-settings.php" class="flex items-center p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                        <div class="bg-blue-100 w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-cog text-blue-600"></i>
                        </div>
                        <span class="font-medium">Settings</span>
                    </a>
                </div>
            </div>
            
            <!-- Profile Completion -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl p-6 text-white">
                <h2 class="text-xl font-bold mb-4">Profile Completion</h2>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span><?php echo ($userData['profile_complete_percentage'] ?? 60); ?>% Complete</span>
                        <span><?php echo ($userData['profile_complete_percentage'] ?? 60); ?>%</span>
                    </div>
                    <div class="w-full bg-blue-300 rounded-full h-2">
                        <div class="bg-white h-2 rounded-full" style="width: <?php echo ($userData['profile_complete_percentage'] ?? 60); ?>%"></div>
                    </div>
                </div>
                <p class="text-sm text-blue-100 mb-4">Complete your profile to increase your chances of getting hired by 70%</p>
                <a href="profile.php" class="block w-full bg-white text-blue-600 text-center py-3 rounded-lg hover:bg-gray-100 font-medium">
                    Complete Profile
                </a>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    <!-- Recruiter Dashboard -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Stats & Quick Actions -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-briefcase text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Active Jobs</p>
                            <p class="text-2xl font-bold text-gray-800">12</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="manage-jobs.php" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Manage Jobs <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-paper-plane text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Applications</p>
                            <p class="text-2xl font-bold text-gray-800">245</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="candidates.php" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-eye text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Profile Views</p>
                            <p class="text-2xl font-bold text-gray-800">1,245</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="company-profile.php" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            View Profile <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-users text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Shortlisted</p>
                            <p class="text-2xl font-bold text-gray-800">24</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="candidates.php?status=shortlisted" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            View Shortlisted <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Applications -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Recent Applications</h2>
                    <a href="candidates.php" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 text-gray-600 font-medium">Candidate</th>
                                <th class="text-left py-3 text-gray-600 font-medium">Job Position</th>
                                <th class="text-left py-3 text-gray-600 font-medium">Applied Date</th>
                                <th class="text-left py-3 text-gray-600 font-medium">Status</th>
                                <th class="text-left py-3 text-gray-600 font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recentApplications = [
                                ['name' => 'John Smith', 'position' => 'Senior Pilot', 'date' => '2024-01-15', 'status' => 'Shortlisted'],
                                ['name' => 'Emma Johnson', 'position' => 'Flight Attendant', 'date' => '2024-01-14', 'status' => 'Pending'],
                                ['name' => 'Michael Brown', 'position' => 'Airport Manager', 'date' => '2024-01-13', 'status' => 'New'],
                                ['name' => 'Sarah Wilson', 'position' => 'Customer Service', 'date' => '2024-01-12', 'status' => 'Rejected'],
                            ];
                            
                            foreach ($recentApplications as $app):
                            ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="font-bold text-blue-600"><?php echo substr($app['name'], 0, 1); ?></span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800"><?php echo $app['name']; ?></p>
                                            <p class="text-gray-500 text-sm">View Profile</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 text-gray-600"><?php echo $app['position']; ?></td>
                                <td class="py-4 text-gray-600"><?php echo date('M d, Y', strtotime($app['date'])); ?></td>
                                <td class="py-4">
                                    <?php
                                    $statusColors = [
                                        'Shortlisted' => 'bg-green-100 text-green-800',
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'New' => 'bg-blue-100 text-blue-800',
                                        'Rejected' => 'bg-red-100 text-red-800'
                                    ];
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium <?php echo $statusColors[$app['status']] ?? 'bg-gray-100 text-gray-800'; ?>">
                                        <?php echo $app['status']; ?>
                                    </span>
                                </td>
                                <td class="py-4">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Active Job Postings -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Active Job Postings</h2>
                    <a href="post-job.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                        <i class="fas fa-plus mr-2"></i>Post New Job
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php
                    $activeJobs = [
                        ['title' => 'Senior Pilot', 'applications' => 45, 'views' => 234, 'status' => 'Active'],
                        ['title' => 'Flight Attendant', 'applications' => 89, 'views' => 567, 'status' => 'Active'],
                        ['title' => 'Airport Manager', 'applications' => 23, 'views' => 123, 'status' => 'Active'],
                        ['title' => 'Customer Service', 'applications' => 67, 'views' => 345, 'status' => 'Active'],
                    ];
                    
                    foreach ($activeJobs as $job):
                    ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 hover:shadow-md transition duration-300">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-bold text-gray-800"><?php echo $job['title']; ?></h3>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded"><?php echo $job['status']; ?></span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <div>
                                <i class="fas fa-paper-plane mr-1"></i>
                                <span><?php echo $job['applications']; ?> applications</span>
                            </div>
                            <div>
                                <i class="fas fa-eye mr-1"></i>
                                <span><?php echo $job['views']; ?> views</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="#" class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 text-sm">
                                View Details
                            </a>
                            <a href="#" class="flex-1 border border-blue-600 text-blue-600 text-center py-2 rounded-lg hover:bg-blue-50 text-sm">
                                Edit
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Profile & Quick Actions -->
        <div class="space-y-8">
            <!-- Company Profile -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center text-white text-2xl font-bold mr-4">
                        <?php echo substr($userData['company_name'] ?? 'C', 0, 1); ?>
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-800 text-lg"><?php echo $userData['company_name'] ?? 'Your Company'; ?></h2>
                        <p class="text-gray-600 text-sm"><?php echo $userData['company_size'] ?? 'Company size not set'; ?></p>
                        <p class="text-gray-500 text-xs">Recruiter since <?php echo date('M Y', strtotime($userData['created_at'] ?? 'now')); ?></p>
                    </div>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-envelope mr-3 text-blue-500"></i>
                        <span class="text-sm"><?php echo $userData['email'] ?? 'Not set'; ?></span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-phone mr-3 text-blue-500"></i>
                        <span class="text-sm"><?php echo $userData['phone'] ?? 'Not set'; ?></span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-globe mr-3 text-blue-500"></i>
                        <span class="text-sm"><?php echo $userData['website'] ?? 'Website not set'; ?></span>
                    </div>
                </div>
                
                <div class="pt-4 border-t">
                    <a href="company-profile.php" class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 font-medium transition duration-300">
                        <i class="fas fa-edit mr-2"></i>Update Company Profile
                    </a>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="post-job.php" class="flex items-center p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                        <div class="bg-blue-100 w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-plus text-blue-600"></i>
                        </div>
                        <span class="font-medium">Post New Job</span>
                    </a>
                    
                    <a href="manage-jobs.php" class="flex items-center p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                        <div class="bg-blue-100 w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-briefcase text-blue-600"></i>
                        </div>
                        <span class="font-medium">Manage Jobs</span>
                    </a>
                    
                    <a href="candidates.php" class="flex items-center p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                        <div class="bg-blue-100 w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <span class="font-medium">View Candidates</span>
                    </a>
                    
                    <a href="company-profile.php" class="flex items-center p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                        <div class="bg-blue-100 w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-building text-blue-600"></i>
                        </div>
                        <span class="font-medium">Company Profile</span>
                    </a>
                </div>
            </div>
            
            <!-- Hiring Statistics -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl p-6 text-white">
                <h2 class="text-xl font-bold mb-4">Hiring Statistics</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Applications this month</span>
                            <span class="font-bold">245</span>
                        </div>
                        <div class="w-full bg-blue-300 rounded-full h-2">
                            <div class="bg-white h-2 rounded-full" style="width: 80%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Hiring rate</span>
                            <span class="font-bold">15%</span>
                        </div>
                        <div class="w-full bg-blue-300 rounded-full h-2">
                            <div class="bg-white h-2 rounded-full" style="width: 15%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Average time to hire</span>
                            <span class="font-bold">21 days</span>
                        </div>
                        <div class="w-full bg-blue-300 rounded-full h-2">
                            <div class="bg-white h-2 rounded-full" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>