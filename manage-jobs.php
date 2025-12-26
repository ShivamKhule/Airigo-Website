<?php
require_once 'includes/auth.php';
$auth = new Auth();

if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'recruiter') {
    header('Location: login.php');
    exit();
}

$userId = $auth->getUserId();
$statusFilter = $_GET['status'] ?? 'all';
$searchQuery = $_GET['search'] ?? '';

$pageTitle = "Manage Jobs";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manage Job Postings</h1>
                    <p class="text-gray-600">View, edit, and manage all your job postings</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="post-job.php" class="bg-blue-600 text-white px-6 py-3   font-semibold hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-plus mr-2"></i>Post New Job
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white   p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Active Jobs</p>
                        <p class="text-2xl font-bold text-gray-800">12</p>
                    </div>
                    <div class="bg-green-100 p-3  ">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white   p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Draft Jobs</p>
                        <p class="text-2xl font-bold text-gray-800">3</p>
                    </div>
                    <div class="bg-yellow-100 p-3  ">
                        <i class="fas fa-pencil-alt text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white   p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Applications</p>
                        <p class="text-2xl font-bold text-gray-800">245</p>
                    </div>
                    <div class="bg-blue-100 p-3  ">
                        <i class="fas fa-paper-plane text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white   p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Closed Jobs</p>
                        <p class="text-2xl font-bold text-gray-800">8</p>
                    </div>
                    <div class="bg-gray-100 p-3  ">
                        <i class="fas fa-archive text-gray-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white   shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" 
                               id="jobSearch"
                               placeholder="Search jobs by title, company, or ID..."
                               class="w-full pl-10 pr-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div>
                    <select id="statusFilter" class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="draft">Draft</option>
                        <option value="pending">Pending Review</option>
                        <option value="closed">Closed</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
            </div>
            
            <!-- Filter Tags -->
            <div class="flex flex-wrap gap-2 mt-4">
                <span class="bg-blue-100 text-blue-600 px-3 py-1   text-sm font-medium">
                    All Jobs <button class="ml-2 text-blue-800">×</button>
                </span>
                <span class="bg-green-100 text-green-600 px-3 py-1   text-sm font-medium">
                    Active <button class="ml-2 text-green-800">×</button>
                </span>
                <button class="text-gray-600 text-sm hover:text-blue-600">
                    Clear all filters
                </button>
            </div>
        </div>

        <!-- Jobs Table -->
        <div class="bg-white   shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Job Title</th>
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Applications</th>
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Status</th>
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Posted Date</th>
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Deadline</th>
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $jobs = [
                            [
                                'id' => 1,
                                'title' => 'Senior Pilot',
                                'company' => 'Airigo Airlines',
                                'applications' => 45,
                                'views' => 234,
                                'status' => 'active',
                                'status_color' => 'bg-green-100 text-green-800',
                                'posted_date' => '2024-01-15',
                                'deadline' => '2024-02-15',
                                'urgent' => true
                            ],
                            [
                                'id' => 2,
                                'title' => 'Flight Attendant',
                                'company' => 'Airigo Airlines',
                                'applications' => 89,
                                'views' => 567,
                                'status' => 'active',
                                'status_color' => 'bg-green-100 text-green-800',
                                'posted_date' => '2024-01-14',
                                'deadline' => '2024-02-14',
                                'urgent' => false
                            ],
                            [
                                'id' => 3,
                                'title' => 'Airport Manager',
                                'company' => 'Airigo Airlines',
                                'applications' => 23,
                                'views' => 123,
                                'status' => 'draft',
                                'status_color' => 'bg-yellow-100 text-yellow-800',
                                'posted_date' => '2024-01-13',
                                'deadline' => '2024-02-13',
                                'urgent' => false
                            ],
                            [
                                'id' => 4,
                                'title' => 'Customer Service Agent',
                                'company' => 'Airigo Airlines',
                                'applications' => 67,
                                'views' => 345,
                                'status' => 'closed',
                                'status_color' => 'bg-gray-100 text-gray-800',
                                'posted_date' => '2024-01-05',
                                'deadline' => '2024-01-31',
                                'urgent' => false
                            ],
                            [
                                'id' => 5,
                                'title' => 'Maintenance Engineer',
                                'company' => 'Airigo Airlines',
                                'applications' => 21,
                                'views' => 189,
                                'status' => 'active',
                                'status_color' => 'bg-green-100 text-green-800',
                                'posted_date' => '2024-01-10',
                                'deadline' => '2024-02-10',
                                'urgent' => true
                            ],
                        ];
                        
                        foreach ($jobs as $job):
                        ?>
                        <tr class="border-b hover:bg-gray-50 transition duration-200">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100   flex items-center justify-center mr-4">
                                        <i class="fas fa-briefcase text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800"><?php echo $job['title']; ?></h3>
                                        <p class="text-gray-600 text-sm"><?php echo $job['company']; ?></p>
                                        <div class="flex items-center mt-1">
                                            <span class="text-gray-500 text-xs">
                                                <i class="fas fa-eye mr-1"></i><?php echo $job['views']; ?> views
                                            </span>
                                            <?php if ($job['urgent']): ?>
                                            <span class="ml-3 bg-red-100 text-red-600 text-xs px-2 py-1  ">URGENT</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-gray-800"><?php echo $job['applications']; ?></p>
                                        <p class="text-gray-500 text-xs">applications</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1   text-sm font-medium <?php echo $job['status_color']; ?>">
                                    <?php echo ucfirst($job['status']); ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                <?php echo date('M d, Y', strtotime($job['posted_date'])); ?>
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                <?php echo date('M d, Y', strtotime($job['deadline'])); ?>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex space-x-2">
                                    <a href="job-details.php?id=<?php echo $job['id']; ?>" 
                                       class="text-blue-600 hover:text-blue-800 p-2"
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="post-job.php?edit=<?php echo $job['id']; ?>" 
                                       class="text-green-600 hover:text-green-800 p-2"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" 
                                       class="text-red-600 hover:text-red-800 p-2"
                                       title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this job?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <div class="relative group">
                                        <button class="text-gray-600 hover:text-gray-800 p-2">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="absolute right-0 mt-2 w-48 bg-white   shadow-lg py-2 hidden group-hover:block z-10">
                                            <a href="candidates.php?job=<?php echo $job['id']; ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-users mr-2"></i>View Candidates
                                            </a>
                                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-copy mr-2"></i>Duplicate Job
                                            </a>
                                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-archive mr-2"></i>Archive
                                            </a>
                                            <div class="border-t my-2"></div>
                                            <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-100">
                                                <i class="fas fa-times-circle mr-2"></i>Close Job
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Table Footer -->
            <div class="px-6 py-4 border-t bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="mb-4 md:mb-0">
                        <p class="text-gray-600 text-sm">
                            Showing 1-5 of 12 jobs
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-4 py-2 border border-gray-300   text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-4 py-2 bg-blue-600 text-white  ">1</button>
                        <button class="px-4 py-2 border border-gray-300   text-gray-700 hover:bg-gray-50">2</button>
                        <button class="px-4 py-2 border border-gray-300   text-gray-700 hover:bg-gray-50">3</button>
                        <button class="px-4 py-2 border border-gray-300   text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200   p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <input type="checkbox" id="selectAll" class="h-4 w-4 text-blue-600   mr-3">
                    <label for="selectAll" class="text-gray-700 font-medium">Select all jobs</label>
                </div>
                <div class="flex space-x-3">
                    <select class="border border-gray-300   px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Bulk Actions</option>
                        <option value="activate">Activate Selected</option>
                        <option value="deactivate">Deactivate Selected</option>
                        <option value="archive">Archive Selected</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button class="bg-blue-600 text-white px-6 py-2   hover:bg-blue-700 font-medium">
                        Apply
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white   shadow-lg p-6">
                <h3 class="font-bold text-gray-800 mb-4">Job Performance</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Average applications per job</span>
                            <span class="font-medium">49</span>
                        </div>
                        <div class="w-full bg-gray-200   h-2">
                            <div class="bg-blue-600 h-2  " style="width: 70%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Hiring success rate</span>
                            <span class="font-medium">15%</span>
                        </div>
                        <div class="w-full bg-gray-200   h-2">
                            <div class="bg-green-600 h-2  " style="width: 15%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white   shadow-lg p-6">
                <h3 class="font-bold text-gray-800 mb-4">Top Performing Jobs</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Flight Attendant</span>
                        <span class="font-medium text-blue-600">89 apps</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Customer Service Agent</span>
                        <span class="font-medium text-blue-600">67 apps</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Senior Pilot</span>
                        <span class="font-medium text-blue-600">45 apps</span>
                    </div>
                </div>
            </div>

            <div class="bg-white   shadow-lg p-6">
                <h3 class="font-bold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="post-job.php" class="flex items-center p-3   hover:bg-blue-50 text-blue-600">
                        <i class="fas fa-plus mr-3"></i>
                        <span>Create New Job Template</span>
                    </a>
                    <a href="#" class="flex items-center p-3   hover:bg-blue-50 text-blue-600">
                        <i class="fas fa-download mr-3"></i>
                        <span>Export Job Data</span>
                    </a>
                    <a href="#" class="flex items-center p-3   hover:bg-blue-50 text-blue-600">
                        <i class="fas fa-chart-bar mr-3"></i>
                        <span>View Analytics Report</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Job search functionality
document.getElementById('jobSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const jobTitle = row.querySelector('td:first-child h3').textContent.toLowerCase();
        const company = row.querySelector('td:first-child p.text-gray-600').textContent.toLowerCase();
        
        if (jobTitle.includes(searchTerm) || company.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Status filter
document.getElementById('statusFilter').addEventListener('change', function() {
    const status = this.value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const statusCell = row.querySelector('td:nth-child(3) span');
        if (!statusCell) return;
        
        const rowStatus = statusCell.textContent.toLowerCase();
        
        if (status === 'all' || rowStatus.includes(status)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>