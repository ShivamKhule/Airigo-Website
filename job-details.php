<?php
require_once 'config/firestore-db.php';
require_once 'includes/functions.php';

$db = new FirestoreDB();
$jobId = $_GET['id'] ?? '';

if (!$jobId) {
    header('Location: job-search.php');
    exit;
}

$job = $db->getJobById($jobId);

if (!$job) {
    // Try to get the first job if specific ID not found (for demo purposes)
    $allJobs = $db->getJobs([], 1);
    if (!empty($allJobs)) {
        $job = reset($allJobs);
        $job['id'] = key($allJobs) ?: $jobId;
    }
}

if (!$job) {
    header('Location: job-search.php');
    exit;
}

$pageTitle = $job['designation'] . ' at ' . $job['companyName'];
include 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="index.php" class="hover:text-blue-600">Home</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="job-search.php" class="hover:text-blue-600">Jobs</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-800"><?= htmlspecialchars($job['designation']) ?></li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Job Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($job['designation']) ?></h1>
                            <h2 class="text-xl text-blue-600 font-semibold mb-4"><?= htmlspecialchars($job['companyName']) ?></h2>
                            
                            <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-4">
                                <span class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                    <?= htmlspecialchars($job['location']) ?>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                                    <?= htmlspecialchars($job['jobType']) ?>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-tag mr-2 text-gray-400"></i>
                                    <?= htmlspecialchars($job['category']) ?>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-money-bill-wave mr-2 text-gray-400"></i>
                                    ₹<?= htmlspecialchars($job['ctc']) ?> per year
                                </span>
                            </div>
                        </div>
                        
                        <?php if ($job['isUrgentHiring']): ?>
                            <span class="bg-red-100 text-red-800 text-sm font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-exclamation-circle mr-1"></i>Urgent Hiring
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-6">
                        <?php 
                        $skills = explode(',', $job['skills']);
                        foreach ($skills as $skill): 
                        ?>
                            <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                <?= htmlspecialchars(trim($skill)) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Posted <?= timeAgo($job['createdAt']) ?>
                        </span>
                        <div class="flex space-x-3">
                            <button class="flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300">
                                <i class="far fa-heart mr-2"></i>Save Job
                            </button>
                            <button class="flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300">
                                <i class="fas fa-share-alt mr-2"></i>Share
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Job Description</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed mb-4"><?= nl2br(htmlspecialchars($job['description'])) ?></p>
                    </div>
                </div>

                <!-- Requirements -->
                <?php if (isset($job['requirements'])): ?>
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Requirements</h3>
                    <div class="prose max-w-none">
                        <?php 
                        $requirements = explode(',', $job['requirements']);
                        ?>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <?php foreach ($requirements as $requirement): ?>
                                <li><?= htmlspecialchars(trim($requirement)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Skills Required -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Skills Required</h3>
                    <div class="flex flex-wrap gap-3">
                        <?php foreach ($skills as $skill): ?>
                            <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg border">
                                <?= htmlspecialchars(trim($skill)) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">About <?= htmlspecialchars($job['companyName']) ?></h3>
                    <div class="flex items-start space-x-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-2xl text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800 mb-2"><?= htmlspecialchars($job['companyName']) ?></h4>
                            <p class="text-gray-600 mb-3">
                                <?= htmlspecialchars($job['companyName']) ?> is a leading company in the <?= htmlspecialchars($job['category']) ?> industry, 
                                committed to excellence and innovation in our field.
                            </p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <?= htmlspecialchars($job['location']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Apply Section -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-6">
                    <div class="text-center mb-6">
                        <div class="text-2xl font-bold text-gray-800 mb-2">₹<?= htmlspecialchars($job['ctc']) ?></div>
                        <div class="text-sm text-gray-600">per year</div>
                    </div>
                    
                    <button class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold mb-3">
                        <i class="fas fa-paper-plane mr-2"></i>Apply Now
                    </button>
                    
                    <button class="w-full border border-gray-300 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-50 transition duration-300 font-semibold">
                        <i class="far fa-heart mr-2"></i>Save for Later
                    </button>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-800 mb-3">Job Details</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Job Type:</span>
                                <span class="font-medium"><?= htmlspecialchars($job['jobType']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium"><?= htmlspecialchars($job['category']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Location:</span>
                                <span class="font-medium"><?= htmlspecialchars($job['location']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Posted:</span>
                                <span class="font-medium"><?= timeAgo($job['createdAt']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Similar Jobs -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Similar Jobs</h3>
                    <?php 
                    $similarJobs = $db->getJobs(['category' => $job['category']], 3);
                    $similarJobs = array_filter($similarJobs, function($j) use ($jobId) {
                        return $j['id'] !== $jobId;
                    });
                    ?>
                    
                    <div class="space-y-4">
                        <?php foreach (array_slice($similarJobs, 0, 3) as $similarJob): ?>
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-300">
                                <h4 class="font-semibold text-gray-800 mb-1">
                                    <a href="job-details.php?id=<?= $similarJob['id'] ?>" class="hover:text-blue-600">
                                        <?= htmlspecialchars($similarJob['designation']) ?>
                                    </a>
                                </h4>
                                <p class="text-sm text-blue-600 mb-2"><?= htmlspecialchars($similarJob['companyName']) ?></p>
                                <div class="flex items-center text-xs text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <?= htmlspecialchars($similarJob['location']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <a href="job-search.php?category=<?= urlencode($job['category']) ?>" 
                       class="block text-center mt-4 text-blue-600 hover:text-blue-700 font-medium">
                        View All <?= htmlspecialchars($job['category']) ?> Jobs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>