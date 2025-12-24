<?php
require_once 'config/firestore-db.php';
require_once 'includes/functions.php';

$db = new FirestoreDB();
$category = $_GET['category'] ?? '';

$pageTitle = $category ? $category . ' Jobs' : 'Browse All Jobs';
include 'includes/header.php';

// Get jobs by category
$filters = [];
if ($category) {
    $filters['category'] = $category;
}
$jobs = $db->getJobs($filters, 50);

// Get job counts by category
$allJobs = $db->getJobs([], 1000);
$categoryCounts = [];
foreach ($allJobs as $job) {
    $cat = $job['category'] ?? 'Other';
    $categoryCounts[$cat] = ($categoryCounts[$cat] ?? 0) + 1;
}
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        <?= $category ? htmlspecialchars($category) . ' Jobs' : 'Browse All Jobs' ?>
                    </h1>
                    <p class="text-gray-600">
                        <?= count($jobs) ?> job<?= count($jobs) !== 1 ? 's' : '' ?> found
                        <?= $category ? ' in ' . htmlspecialchars($category) : '' ?>
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="job-search.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-search mr-2"></i>Advanced Search
                    </a>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Categories Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Job Categories</h3>
                    
                    <div class="space-y-2">
                        <a href="browse-jobs.php" 
                           class="flex justify-between items-center p-3 rounded-lg hover:bg-gray-50 transition duration-300 <?= !$category ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700' ?>">
                            <span>All Jobs</span>
                            <span class="text-sm bg-gray-100 px-2 py-1 rounded"><?= array_sum($categoryCounts) ?></span>
                        </a>
                        
                        <?php foreach ($categoryCounts as $cat => $count): ?>
                            <a href="browse-jobs.php?category=<?= urlencode($cat) ?>" 
                               class="flex justify-between items-center p-3 rounded-lg hover:bg-gray-50 transition duration-300 <?= $category === $cat ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700' ?>">
                                <span><?= htmlspecialchars($cat) ?></span>
                                <span class="text-sm bg-gray-100 px-2 py-1 rounded"><?= $count ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="lg:w-3/4">
                <?php if (empty($jobs)): ?>
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <i class="fas fa-briefcase text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No Jobs Found</h3>
                        <p class="text-gray-500 mb-6">
                            <?= $category ? 'No jobs available in ' . htmlspecialchars($category) . ' category.' : 'No jobs available at the moment.' ?>
                        </p>
                        <a href="browse-jobs.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                            Browse All Jobs
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-y-6">
                        <?php foreach ($jobs as $job): ?>
                            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 p-6">
                                <div class="flex flex-col md:flex-row justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-building text-blue-600"></i>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-semibold text-gray-800 mb-1">
                                                        <a href="job-details.php?id=<?= $job['id'] ?>" class="hover:text-blue-600 transition duration-300">
                                                            <?= htmlspecialchars($job['designation']) ?>
                                                        </a>
                                                    </h3>
                                                    <p class="text-lg text-blue-600 font-medium"><?= htmlspecialchars($job['companyName']) ?></p>
                                                </div>
                                            </div>
                                            <?php if ($job['isUrgentHiring']): ?>
                                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>Urgent Hiring
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600 mb-4">
                                            <div class="flex items-center">
                                                <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                                <?= htmlspecialchars($job['location']) ?>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-clock mr-2 text-gray-400"></i>
                                                <?= htmlspecialchars($job['jobType']) ?>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-tag mr-2 text-gray-400"></i>
                                                <?= htmlspecialchars($job['category']) ?>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-money-bill-wave mr-2 text-gray-400"></i>
                                                ₹<?= htmlspecialchars($job['ctc']) ?>
                                            </div>
                                        </div>
                                        
                                        <p class="text-gray-600 mb-4 line-clamp-2">
                                            <?= htmlspecialchars(substr($job['description'], 0, 200)) ?>...
                                        </p>
                                        
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <?php 
                                            $skills = explode(',', $job['skills']);
                                            foreach (array_slice($skills, 0, 4) as $skill): 
                                            ?>
                                                <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full">
                                                    <?= htmlspecialchars(trim($skill)) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center pt-4 border-t border-gray-100">
                                    <span class="text-sm text-gray-500 mb-3 md:mb-0">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Posted <?= timeAgo($job['createdAt']) ?>
                                    </span>
                                    <div class="flex space-x-3">
                                        <button class="flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300 text-sm">
                                            <i class="far fa-heart mr-2"></i>Save
                                        </button>
                                        <a href="job-details.php?id=<?= $job['id'] ?>" 
                                           class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300 text-sm font-medium">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Load More Button -->
                    <?php if (count($jobs) >= 20): ?>
                        <div class="text-center mt-8">
                            <button class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-300 transition duration-300 font-medium">
                                Load More Jobs
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>