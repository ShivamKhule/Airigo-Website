<?php
require_once 'includes/auth.php';
$auth = new Auth();

if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'recruiter') {
    header('Location: login.php');
    exit();
}

$jobId = $_GET['job'] ?? '';
$statusFilter = $_GET['status'] ?? 'all';

$pageTitle = "Candidate Management";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Candidate Management</h1>
                    <p class="text-gray-600">Review and manage all job applications</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="manage-jobs.php" class="bg-blue-600 text-white px-6 py-3   font-semibold hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-briefcase mr-2"></i>View Jobs
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-white   p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Candidates</p>
                        <p class="text-2xl font-bold text-gray-800">245</p>
                    </div>
                    <div class="bg-blue-100 p-3  ">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white   p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">New Applications</p>
                        <p class="text-2xl font-bold text-gray-800">42</p>
                    </div>
                    <div class="bg-green-100 p-3  ">
                        <i class="fas fa-plus-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white   p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Shortlisted</p>
                        <p class="text-2xl font-bold text-gray-800">24</p>
                    </div>
                    <div class="bg-purple-100 p-3  ">
                        <i class="fas fa-star text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white   p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Interview</p>
                        <p class="text-2xl font-bold text-gray-800">8</p>
                    </div>
                    <div class="bg-yellow-100 p-3  ">
                        <i class="fas fa-calendar-alt text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white   p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Hired</p>
                        <p class="text-2xl font-bold text-gray-800">5</p>
                    </div>
                    <div class="bg-green-100 p-3  ">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white   shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <div class="lg:col-span-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" 
                               placeholder="Search candidates by name, email, or skills..."
                               class="w-full pl-10 pr-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div>
                    <select class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Jobs</option>
                        <option value="1">Senior Pilot</option>
                        <option value="2">Flight Attendant</option>
                        <option value="3">Airport Manager</option>
                    </select>
                </div>
                
                <div>
                    <select class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Status</option>
                        <option value="new">New</option>
                        <option value="reviewed">Reviewed</option>
                        <option value="shortlisted">Shortlisted</option>
                        <option value="interview">Interview</option>
                        <option value="rejected">Rejected</option>
                        <option value="hired">Hired</option>
                    </select>
                </div>
            </div>
            
            <!-- Advanced Filters -->
            <div class="mt-6 pt-6 border-t">
                <button id="toggleAdvancedFilters" class="text-blue-600 hover:text-blue-800 font-medium">
                    <i class="fas fa-filter mr-2"></i>Advanced Filters
                </button>
                
                <div id="advancedFilters" class="hidden mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Experience Level</label>
                        <select class="w-full px-4 py-2 border border-gray-300  ">
                            <option value="">Any Experience</option>
                            <option value="entry">Entry Level</option>
                            <option value="mid">Mid Level</option>
                            <option value="senior">Senior Level</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" 
                               class="w-full px-4 py-2 border border-gray-300  "
                               placeholder="City, Country">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date Applied</label>
                        <select class="w-full px-4 py-2 border border-gray-300  ">
                            <option value="">Any Date</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Candidates Table -->
        <div class="bg-white   shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">
                                <input type="checkbox" class="h-4 w-4 text-blue-600  ">
                            </th>
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Candidate</th>
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Job Applied</th>
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Date Applied</th>
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Status</th>
                            <th class="text-left py-4 px-6 text-gray-600 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $candidates = [
                            [
                                'id' => 1,
                                'name' => 'John Smith',
                                'email' => 'john.smith@example.com',
                                'profile_img' => null,
                                'job_title' => 'Senior Pilot',
                                'company' => 'Airigo Airlines',
                                'applied_date' => '2024-01-15',
                                'status' => 'shortlisted',
                                'status_color' => 'bg-purple-100 text-purple-800',
                                'experience' => '8 years',
                                'location' => 'New York, USA',
                                'last_contact' => '2024-01-18'
                            ],
                            [
                                'id' => 2,
                                'name' => 'Emma Johnson',
                                'email' => 'emma.j@example.com',
                                'profile_img' => null,
                                'job_title' => 'Flight Attendant',
                                'company' => 'Airigo Airlines',
                                'applied_date' => '2024-01-14',
                                'status' => 'interview',
                                'status_color' => 'bg-yellow-100 text-yellow-800',
                                'experience' => '3 years',
                                'location' => 'London, UK',
                                'last_contact' => '2024-01-17'
                            ],
                            [
                                'id' => 3,
                                'name' => 'Michael Brown',
                                'email' => 'michael.b@example.com',
                                'profile_img' => null,
                                'job_title' => 'Airport Manager',
                                'company' => 'Airigo Airlines',
                                'applied_date' => '2024-01-13',
                                'status' => 'new',
                                'status_color' => 'bg-blue-100 text-blue-800',
                                'experience' => '10 years',
                                'location' => 'Dubai, UAE',
                                'last_contact' => '2024-01-13'
                            ],
                            [
                                'id' => 4,
                                'name' => 'Sarah Wilson',
                                'email' => 'sarah.w@example.com',
                                'profile_img' => null,
                                'job_title' => 'Customer Service Agent',
                                'company' => 'Airigo Airlines',
                                'applied_date' => '2024-01-12',
                                'status' => 'rejected',
                                'status_color' => 'bg-red-100 text-red-800',
                                'experience' => '2 years',
                                'location' => 'Miami, USA',
                                'last_contact' => '2024-01-16'
                            ],
                            [
                                'id' => 5,
                                'name' => 'David Miller',
                                'email' => 'david.m@example.com',
                                'profile_img' => null,
                                'job_title' => 'Maintenance Engineer',
                                'company' => 'Airigo Airlines',
                                'applied_date' => '2024-01-11',
                                'status' => 'hired',
                                'status_color' => 'bg-green-100 text-green-800',
                                'experience' => '6 years',
                                'location' => 'Sydney, Australia',
                                'last_contact' => '2024-01-20'
                            ],
                        ];
                        
                        foreach ($candidates as $candidate):
                        ?>
                        <tr class="border-b hover:bg-gray-50 transition duration-200">
                            <td class="py-4 px-6">
                                <input type="checkbox" class="h-4 w-4 text-blue-600   candidate-checkbox">
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100   flex items-center justify-center mr-4">
                                        <span class="font-bold text-blue-600"><?php echo substr($candidate['name'], 0, 1); ?></span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800"><?php echo $candidate['name']; ?></h3>
                                        <p class="text-gray-600 text-sm"><?php echo $candidate['email']; ?></p>
                                        <div class="flex items-center mt-1">
                                            <span class="text-gray-500 text-xs">
                                                <i class="fas fa-briefcase mr-1"></i><?php echo $candidate['experience']; ?>
                                            </span>
                                            <span class="mx-2 text-gray-300">•</span>
                                            <span class="text-gray-500 text-xs">
                                                <i class="fas fa-map-marker-alt mr-1"></i><?php echo $candidate['location']; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div>
                                    <p class="font-medium text-gray-800"><?php echo $candidate['job_title']; ?></p>
                                    <p class="text-gray-600 text-sm"><?php echo $candidate['company']; ?></p>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                <?php echo date('M d, Y', strtotime($candidate['applied_date'])); ?>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1   text-sm font-medium <?php echo $candidate['status_color']; ?>">
                                    <?php echo ucfirst($candidate['status']); ?>
                                </span>
                                <p class="text-gray-500 text-xs mt-1">
                                    Last contact: <?php echo date('M d', strtotime($candidate['last_contact'])); ?>
                                </p>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex space-x-2">
                                    <a href="candidate-details.php?id=<?php echo $candidate['id']; ?>" 
                                       class="text-blue-600 hover:text-blue-800 p-2"
                                       title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" 
                                       class="text-green-600 hover:text-green-800 p-2"
                                       title="Download Resume">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="relative group">
                                        <button class="text-gray-600 hover:text-gray-800 p-2">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="absolute right-0 mt-2 w-48 bg-white   shadow-lg py-2 hidden group-hover:block z-10">
                                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-envelope mr-2"></i>Send Email
                                            </a>
                                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-phone mr-2"></i>Schedule Call
                                            </a>
                                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-calendar-alt mr-2"></i>Schedule Interview
                                            </a>
                                            <div class="border-t my-2"></div>
                                            <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-100">
                                                <i class="fas fa-times-circle mr-2"></i>Reject
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
                            Showing 1-5 of 245 candidates
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

        <!-- Bulk Actions and Export -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Bulk Actions -->
            <div class="lg:col-span-2">
                <div class="bg-white   shadow-lg p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Bulk Actions</h3>
                    <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                            <select class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Action</option>
                                <option value="shortlist">Shortlist Selected</option>
                                <option value="reject">Reject Selected</option>
                                <option value="interview">Schedule Interview</option>
                                <option value="email">Send Bulk Email</option>
                                <option value="download">Download Resumes</option>
                            </select>
                        </div>
                        <button class="bg-blue-600 text-white px-8 py-3   hover:bg-blue-700 font-medium">
                            Apply to Selected
                        </button>
                        <button class="border border-gray-300 text-gray-700 px-6 py-3   hover:bg-gray-50 font-medium">
                            Clear Selection
                        </button>
                    </div>
                    
                    <!-- Quick Status Update -->
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="font-medium text-gray-700 mb-3">Quick Status Update</h4>
                        <div class="flex flex-wrap gap-2">
                            <button class="bg-green-100 text-green-800 px-4 py-2   hover:bg-green-200">
                                Mark as Shortlisted
                            </button>
                            <button class="bg-yellow-100 text-yellow-800 px-4 py-2   hover:bg-yellow-200">
                                Schedule Interview
                            </button>
                            <button class="bg-red-100 text-red-800 px-4 py-2   hover:bg-red-200">
                                Reject Application
                            </button>
                            <button class="bg-blue-100 text-blue-800 px-4 py-2   hover:bg-blue-200">
                                Send Follow-up
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Options -->
            <div>
                <div class="bg-white   shadow-lg p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Export Data</h3>
                    <div class="space-y-3">
                        <button class="w-full flex items-center justify-between p-3 border border-gray-200   hover:bg-gray-50">
                            <span class="text-gray-700">
                                <i class="fas fa-file-excel text-green-600 mr-2"></i>
                                Export to Excel
                            </span>
                            <i class="fas fa-download text-gray-400"></i>
                        </button>
                        <button class="w-full flex items-center justify-between p-3 border border-gray-200   hover:bg-gray-50">
                            <span class="text-gray-700">
                                <i class="fas fa-file-pdf text-red-600 mr-2"></i>
                                Export to PDF
                            </span>
                            <i class="fas fa-download text-gray-400"></i>
                        </button>
                        <button class="w-full flex items-center justify-between p-3 border border-gray-200   hover:bg-gray-50">
                            <span class="text-gray-700">
                                <i class="fas fa-file-csv text-blue-600 mr-2"></i>
                                Export to CSV
                            </span>
                            <i class="fas fa-download text-gray-400"></i>
                        </button>
                    </div>
                    
                    <!-- Candidate Pipeline -->
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="font-medium text-gray-700 mb-3">Candidate Pipeline</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">New Applications</span>
                                <span class="font-medium">42</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Under Review</span>
                                <span class="font-medium">156</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Interview Stage</span>
                                <span class="font-medium">8</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Offer Stage</span>
                                <span class="font-medium">3</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle advanced filters
document.getElementById('toggleAdvancedFilters').addEventListener('click', function() {
    const filters = document.getElementById('advancedFilters');
    if (filters.classList.contains('hidden')) {
        filters.classList.remove('hidden');
        this.innerHTML = '<i class="fas fa-filter mr-2"></i>Hide Filters';
    } else {
        filters.classList.add('hidden');
        this.innerHTML = '<i class="fas fa-filter mr-2"></i>Advanced Filters';
    }
});

// Candidate checkbox selection
const candidateCheckboxes = document.querySelectorAll('.candidate-checkbox');
const headerCheckbox = document.querySelector('thead input[type="checkbox"]');

headerCheckbox.addEventListener('change', function() {
    candidateCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Initialize tooltips
document.querySelectorAll('[title]').forEach(element => {
    element.addEventListener('mouseenter', function() {
        const tooltip = document.createElement('div');
        tooltip.className = 'fixed bg-gray-900 text-white px-2 py-1   text-sm z-50';
        tooltip.textContent = this.getAttribute('title');
        document.body.appendChild(tooltip);
        
        const rect = this.getBoundingClientRect();
        tooltip.style.left = rect.left + 'px';
        tooltip.style.top = (rect.top - 30) + 'px';
        
        this._tooltip = tooltip;
    });
    
    element.addEventListener('mouseleave', function() {
        if (this._tooltip) {
            document.body.removeChild(this._tooltip);
            delete this._tooltip;
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>