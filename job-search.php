<?php
require_once 'config/firestore-db.php';
require_once 'includes/functions.php';

$db = new FirestoreDB();

// Get search parameters
$keyword = $_GET['keyword'] ?? '';
$location = $_GET['location'] ?? '';
$category = $_GET['category'] ?? '';
$jobType = $_GET['jobType'] ?? '';
$company = $_GET['company'] ?? '';

// Build filters
$filters = [];
if ($category) $filters['category'] = $category;
if ($jobType) $filters['jobType'] = $jobType;
if ($company) $filters['companyName'] = $company;

// Get jobs
if ($keyword || $location) {
    // If searching by keyword/location AND company is specified, we need to filter results
    if ($company) {
        $searchResults = $db->searchJobs($keyword, $location, 20);
        $jobs = [];
        foreach ($searchResults as $job) {
            if (isset($job['companyName']) && $job['companyName'] === $company) {
                $jobs[] = $job;
            }
        }
    } else {
        $jobs = $db->searchJobs($keyword, $location, 20);
    }
} else {
    $jobs = $db->getJobs($filters, 20);
}

$pageTitle = 'Job Search - Find Your Dream Career';

include 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Search Header -->
        <div class="bg-white shadow-md p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Find Your Perfect Job</h1>
            
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" 
                               placeholder="Job title, skills, company..." 
                               class="w-full px-4 py-3 border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <input type="text" name="location" value="<?= htmlspecialchars($location) ?>" 
                               placeholder="City, state, country..." 
                               class="w-full px-4 py-3 border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <select name="category" class="w-full px-4 py-3 border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Categories</option>
                            <option value="Airline" <?= $category === 'Airline' ? 'selected' : '' ?>>Airline</option>
                            <option value="Hospitality" <?= $category === 'Hospitality' ? 'selected' : '' ?>>Hospitality</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 hover:bg-blue-700 transition duration-300 font-semibold">
                            <i class="fas fa-search mr-2"></i>Search Jobs
                        </button>
                    </div>
                </div>
                <?php if ($company): ?>
                <input type="hidden" name="company" value="<?= htmlspecialchars($company) ?>">
                <?php endif; ?>
            </form>
        </div>

        <!-- Results -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white   shadow-md p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Jobs</h3>
                    
                    <form method="GET">
                        <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>">
                        <input type="hidden" name="location" value="<?= htmlspecialchars($location) ?>">
                        <?php if ($company): ?>
                        <input type="hidden" name="company" value="<?= htmlspecialchars($company) ?>">
                        <?php endif; ?>
                        
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-3">Job Type</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="jobType" value="" <?= !$jobType ? 'checked' : '' ?> class="mr-2">
                                    <span class="text-sm">All Types</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="jobType" value="Full-time" <?= $jobType === 'Full-time' ? 'checked' : '' ?> class="mr-2">
                                    <span class="text-sm">Full-time</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="jobType" value="Part-time" <?= $jobType === 'Part-time' ? 'checked' : '' ?> class="mr-2">
                                    <span class="text-sm">Part-time</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="jobType" value="Contract" <?= $jobType === 'Contract' ? 'checked' : '' ?> class="mr-2">
                                    <span class="text-sm">Contract</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-3">Category</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="" <?= !$category ? 'checked' : '' ?> class="mr-2">
                                    <span class="text-sm">All Categories</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="Airline" <?= $category === 'Airline' ? 'checked' : '' ?> class="mr-2">
                                    <span class="text-sm">Airline</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="Hospitality" <?= $category === 'Hospitality' ? 'checked' : '' ?> class="mr-2">
                                    <span class="text-sm">Hospitality</span>
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 hover:bg-gray-900 transition duration-300">
                            Apply Filters
                        </button>
                    </form>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="lg:w-3/4">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <?= count($jobs) ?> Jobs Found
                        <?php if ($keyword || $location || $category || $company): ?>
                            for "<?= htmlspecialchars($keyword ?: $location ?: $category ?: $company) ?>"
                        <?php endif; ?>
                    </h2>
                </div>

                <div class="space-y-6">
                    <?php if (empty($jobs)): ?>
                        <div class="bg-white shadow-md p-8 text-center">
                            <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Jobs Found</h3>
                            <p class="text-gray-500">Try adjusting your search criteria or browse all jobs.</p>
                            <a href="job-search.php" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 hover:bg-blue-700 transition duration-300">
                                View All Jobs
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($jobs as $job): ?>
                            <div class="bg-white shadow-md hover:shadow-lg transition duration-300 p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">
                                            <a href="job-details.php?id=<?= $job['id'] ?>" class="hover:text-blue-600 transition duration-300">
                                                <?= htmlspecialchars($job['designation']) ?>
                                            </a>
                                        </h3>
                                        <p class="text-lg text-blue-600 font-medium mb-2"><?= htmlspecialchars($job['companyName']) ?></p>
                                        <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-3">
                                            <span><i class="fas fa-map-marker-alt mr-1"></i><?= htmlspecialchars($job['location']) ?></span>
                                            <span><i class="fas fa-clock mr-1"></i><?= htmlspecialchars($job['jobType']) ?></span>
                                            <span><i class="fas fa-tag mr-1"></i><?= htmlspecialchars($job['category']) ?></span>
                                            <span><i class="fas fa-money-bill-wave mr-1"></i><?= htmlspecialchars($job['ctc']) ?></span>
                                        </div>
                                    </div>
                                    <?php if ($job['isUrgentHiring']): ?>
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1">
                                            Urgent Hiring
                                        </span>
                                    <?php endif; ?>
                                </div>
                                                                
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <?php 
                                    $skills = explode(',', $job['skills']);
                                    foreach (array_slice($skills, 0, 3) as $skill): 
                                    ?>
                                        <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1">
                                            <?= htmlspecialchars(trim($skill)) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="flex justify-end items-center">
                                    <!-- <span class="text-sm text-gray-500">
                                        Posted <?php echo (new DateTime($job['createdAt']))->format('F j, Y'); ?>
                                    </span> -->
                                    <div class="space-x-2">
                                        <button class="text-gray-400 hover:text-red-500 transition duration-300" title="Save Job">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <a href="job-details.php?id=<?= $job['id'] ?>" 
                                           class="bg-blue-600 text-white px-4 py-2 hover:bg-blue-700 transition duration-300">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>