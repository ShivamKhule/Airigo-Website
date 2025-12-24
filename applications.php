<?php
require_once 'includes/auth.php';
$auth = new Auth();

if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'jobseeker') {
    header('Location: login.php');
    exit();
}

$userId = $auth->getUserId();
$statusFilter = $_GET['status'] ?? 'all';

$pageTitle = "My Applications";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Job Applications</h1>
            <p class="text-gray-600">Track and manage all your job applications in one place</p>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Applications</p>
                        <p class="text-2xl font-bold text-gray-800">24</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-paper-plane text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Shortlisted</p>
                        <p class="text-2xl font-bold text-gray-800">5</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Pending</p>
                        <p class="text-2xl font-bold text-gray-800">15</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Rejected</p>
                        <p class="text-2xl font-bold text-gray-800">4</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-lg">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">Filters</h3>
                    
                    <!-- Status Filter -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-3">Application Status</h4>
                        <div class="space-y-2">
                            <a href="?status=all" 
                               class="block px-3 py-2 rounded-lg <?php echo $statusFilter === 'all' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100'; ?>">
                                <div class="flex items-center justify-between">
                                    <span>All Applications</span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">24</span>
                                </div>
                            </a>
                            <a href="?status=applied" 
                               class="block px-3 py-2 rounded-lg <?php echo $statusFilter === 'applied' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100'; ?>">
                                <div class="flex items-center justify-between">
                                    <span>Applied</span>
                                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs">15</span>
                                </div>
                            </a>
                            <a href="?status=shortlisted" 
                               class="block px-3 py-2 rounded-lg <?php echo $statusFilter === 'shortlisted' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100'; ?>">
                                <div class="flex items-center justify-between">
                                    <span>Shortlisted</span>
                                    <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">5</span>
                                </div>
                            </a>
                            <a href="?status=interview" 
                               class="block px-3 py-2 rounded-lg <?php echo $statusFilter === 'interview' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100'; ?>">
                                <div class="flex items-center justify-between">
                                    <span>Interview</span>
                                    <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded text-xs">3</span>
                                </div>
                            </a>
                            <a href="?status=rejected" 
                               class="block px-3 py-2 rounded-lg <?php echo $statusFilter === 'rejected' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100'; ?>">
                                <div class="flex items-center justify-between">
                                    <span>Rejected</span>
                                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">4</span>
                                </div>
                            </a>
                            <a href="?status=withdrawn" 
                               class="block px-3 py-2 rounded-lg <?php echo $statusFilter === 'withdrawn' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100'; ?>">
                                <div class="flex items-center justify-between">
                                    <span>Withdrawn</span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">1</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Date Filter -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-3">Date Applied</h4>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded">
                                <span class="ml-2 text-gray-600">Last 7 days</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded">
                                <span class="ml-2 text-gray-600">Last 30 days</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded">
                                <span class="ml-2 text-gray-600">Last 3 months</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded">
                                <span class="ml-2 text-gray-600">Last 6 months</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Job Type Filter -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-3">Job Type</h4>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded">
                                <span class="ml-2 text-gray-600">Full-time</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded">
                                <span class="ml-2 text-gray-600">Part-time</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded">
                                <span class="ml-2 text-gray-600">Contract</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 rounded">
                                <span class="ml-2 text-gray-600">Remote</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="pt-4 border-t">
                        <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 mb-3">
                            Apply Filters
                        </button>
                        <button class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50">
                            Reset All
                        </button>
                    </div>
                </div>
                
                <!-- Application Tips -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="font-bold text-lg text-blue-800 mb-4">Application Tips</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                            <span class="text-blue-700 text-sm">Follow up after 7-10 days if no response</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                            <span class="text-blue-700 text-sm">Prepare for potential interview questions</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                            <span class="text-blue-700 text-sm">Update your resume regularly</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                            <span class="text-blue-700 text-sm">Research companies before applying</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Applications List -->
            <div class="lg:col-span-3">
                <!-- Applications Header -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">
                                <?php 
                                $statusTitles = [
                                    'all' => 'All Applications',
                                    'applied' => 'Applied Jobs',
                                    'shortlisted' => 'Shortlisted Applications',
                                    'interview' => 'Interview Scheduled',
                                    'rejected' => 'Rejected Applications',
                                    'withdrawn' => 'Withdrawn Applications'
                                ];
                                echo $statusTitles[$statusFilter] ?? 'All Applications';
                                ?>
                            </h2>
                            <p class="text-gray-600">Showing <?php echo $statusFilter === 'all' ? '24' : ($statusFilter === 'applied' ? '15' : ($statusFilter === 'shortlisted' ? '5' : ($statusFilter === 'interview' ? '3' : ($statusFilter === 'rejected' ? '4' : '1')))); ?> applications</p>
                        </div>
                        <div class="flex items-center space-x-4 mt-4 md:mt-0">
                            <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 font-medium">
                                <i class="fas fa-download mr-2"></i>Export
                            </button>
                            <div class="relative">
                                <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Sort by: Newest</option>
                                    <option>Sort by: Oldest</option>
                                    <option>Sort by: Status</option>
                                    <option>Sort by: Company</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Applications -->
                <div class="space-y-6">
                    <?php
                    $applications = [
                        [
                            'id' => 1,
                            'job_title' => 'Senior Pilot',
                            'company' => 'Airigo Airlines',
                            'company_logo' => 'https://images.unsplash.com/photo-1606768666853-403c90a981ad?w=100&h=100&fit=crop',
                            'location' => 'New York, USA',
                            'salary' => '$120,000 - $180,000',
                            'applied_date' => '2024-01-15',
                            'status' => 'shortlisted',
                            'status_color' => 'bg-green-100 text-green-800',
                            'last_update' => '2024-01-18',
                            'notes' => 'Interview scheduled for Jan 25, 2024'
                        ],
                        [
                            'id' => 2,
                            'job_title' => 'Flight Attendant',
                            'company' => 'SkyJet Airways',
                            'company_logo' => 'https://images.unsplash.com/photo-1611597617014-9970403724e9?w=100&h=100&fit=crop',
                            'location' => 'London, UK',
                            'salary' => '$45,000 - $65,000',
                            'applied_date' => '2024-01-14',
                            'status' => 'interview',
                            'status_color' => 'bg-purple-100 text-purple-800',
                            'last_update' => '2024-01-17',
                            'notes' => 'Technical interview completed'
                        ],
                        [
                            'id' => 3,
                            'job_title' => 'Airport Manager',
                            'company' => 'Global Airports Inc.',
                            'company_logo' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=100&h=100&fit=crop',
                            'location' => 'Dubai, UAE',
                            'salary' => '$80,000 - $120,000',
                            'applied_date' => '2024-01-13',
                            'status' => 'applied',
                            'status_color' => 'bg-blue-100 text-blue-800',
                            'last_update' => '2024-01-13',
                            'notes' => 'Application under review'
                        ],
                        [
                            'id' => 4,
                            'job_title' => 'Hospitality Manager',
                            'company' => 'Luxury Hotels Group',
                            'company_logo' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=100&h=100&fit=crop',
                            'location' => 'Miami, USA',
                            'salary' => '$60,000 - $85,000',
                            'applied_date' => '2024-01-12',
                            'status' => 'rejected',
                            'status_color' => 'bg-red-100 text-red-800',
                            'last_update' => '2024-01-16',
                            'notes' => 'Position filled internally'
                        ],
                        [
                            'id' => 5,
                            'job_title' => 'Remote Customer Service Agent',
                            'company' => 'Travel Support Inc.',
                            'company_logo' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=100&h=100&fit=crop',
                            'location' => 'Remote',
                            'salary' => '$35,000 - $50,000',
                            'applied_date' => '2024-01-10',
                            'status' => 'applied',
                            'status_color' => 'bg-blue-100 text-blue-800',
                            'last_update' => '2024-01-10',
                            'notes' => 'Application received'
                        ],
                    ];
                    
                    foreach ($applications as $app):
                        if ($statusFilter !== 'all' && $statusFilter !== $app['status']) {
                            continue;
                        }
                    ?>
                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-6">
                            <div class="flex items-start mb-4 lg:mb-0">
                                <img src="<?php echo $app['company_logo']; ?>" 
                                     alt="<?php echo $app['company']; ?>" 
                                     class="w-16 h-16 rounded-lg object-cover mr-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo $app['job_title']; ?></h3>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <p class="text-gray-700 font-medium"><?php echo $app['company']; ?></p>
                                        <span class="text-gray-400">•</span>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            <span><?php echo $app['location']; ?></span>
                                        </div>
                                        <span class="text-gray-400">•</span>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-money-bill-wave mr-2"></i>
                                            <span><?php echo $app['salary']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="<?php echo $app['status_color']; ?> px-4 py-2 rounded-full font-medium">
                                <?php echo ucfirst($app['status']); ?>
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Applied Date</p>
                                <p class="font-medium text-gray-800"><?php echo date('M d, Y', strtotime($app['applied_date'])); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Last Update</p>
                                <p class="font-medium text-gray-800"><?php echo date('M d, Y', strtotime($app['last_update'])); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Application ID</p>
                                <p class="font-medium text-gray-800">APP-<?php echo str_pad($app['id'], 6, '0', STR_PAD_LEFT); ?></p>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <p class="text-sm text-gray-600 mb-1">Notes:</p>
                            <p class="text-gray-800"><?php echo $app['notes']; ?></p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pt-4 border-t">
                            <div class="mb-4 sm:mb-0">
                                <a href="job-details.php?id=<?php echo $app['id']; ?>" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    <i class="fas fa-eye mr-2"></i>View Job Details
                                </a>
                            </div>
                            <div class="flex space-x-3">
                                <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 font-medium">
                                    <i class="fas fa-edit mr-2"></i>Update
                                </button>
                                <?php if ($app['status'] === 'applied'): ?>
                                <button class="border border-red-300 text-red-600 px-4 py-2 rounded-lg hover:bg-red-50 font-medium">
                                    <i class="fas fa-times mr-2"></i>Withdraw
                                </button>
                                <?php endif; ?>
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">
                                    <i class="fas fa-comment mr-2"></i>Contact
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- No Applications -->
                <?php if (empty($applications) || ($statusFilter !== 'all' && !in_array($statusFilter, array_column($applications, 'status')))): ?>
                <div class="text-center py-12">
                    <div class="mb-6">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">No applications found</h3>
                        <p class="text-gray-600">You haven't applied to any jobs with the selected filters</p>
                    </div>
                    <a href="job-search.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">
                        Browse Jobs
                    </a>
                </div>
                <?php endif; ?>
                
                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    <nav class="inline-flex rounded-md shadow">
                        <a href="#" class="px-4 py-2 border border-gray-300 rounded-l-lg text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="#" class="px-4 py-2 border-t border-b border-gray-300 text-blue-600 bg-blue-50">1</a>
                        <a href="#" class="px-4 py-2 border-t border-b border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                        <a href="#" class="px-4 py-2 border-t border-b border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                        <a href="#" class="px-4 py-2 border border-gray-300 rounded-r-lg text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>