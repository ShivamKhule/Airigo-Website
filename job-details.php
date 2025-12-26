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
    header('Location: job-search.php');
    exit;
}

$pageTitle = $job['designation'] . ' | ' . $job['companyName'];
include 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">

        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm text-gray-600">
            <a href="index.php" class="hover:text-blue-600">Home</a> /
            <a href="job-search.php" class="hover:text-blue-600">Jobs</a> /
            <span class="text-gray-800"><?= htmlspecialchars($job['designation']) ?></span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- ================= MAIN CONTENT ================= -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Job Header -->
                <div class="bg-white shadow-md p-6">
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-1">
                                <?= htmlspecialchars($job['designation']) ?>
                            </h1>
                            <p class="text-xl text-blue-600 font-semibold mb-3">
                                <?= htmlspecialchars($job['companyName']) ?>
                            </p>

                            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                <?php if (!empty($job['location'])): ?>
                                    <span><i class="fas fa-map-marker-alt mr-1"></i><?= htmlspecialchars($job['location']) ?></span>
                                <?php endif; ?>

                                <?php if (!empty($job['jobType'])): ?>
                                    <span><i class="fas fa-clock mr-1"></i><?= htmlspecialchars($job['jobType']) ?></span>
                                <?php endif; ?>

                                <?php if (!empty($job['category'])): ?>
                                    <span><i class="fas fa-tag mr-1"></i><?= htmlspecialchars($job['category']) ?></span>
                                <?php endif; ?>

                                <?php if (!empty($job['ctc'])): ?>
                                    <span><i class="fas fa-money-bill-wave mr-1"></i><?= htmlspecialchars($job['ctc']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($job['isUrgentHiring'])): ?>
                            <span class="bg-red-100 text-red-700 px-3 py-1 text-sm font-semibold">
                                Urgent Hiring
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($job['skills'])): ?>
                        <div class="mt-4">
                            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 text-sm">
                                <?= htmlspecialchars($job['skills']) ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div class="mt-4 text-sm text-gray-500">
                        Posted <?= getPostedText($job['createdAt'] ?? null) ?>
                    </div>
                </div>

                <!-- Requirements -->
                <?php if (!empty($job['requirements'])): ?>
                    <div class="bg-white shadow-md p-6">
                        <h3 class="text-xl font-semibold mb-3">Requirements</h3>
                        <p class="text-gray-700"><?= htmlspecialchars($job['requirements']) ?></p>
                    </div>
                <?php endif; ?>

                <!-- Job Responsibilities -->
                <?php if (!empty($job['application'])): ?>
                    <div class="bg-white shadow-md p-6">
                        <h3 class="text-xl font-semibold mb-3">Job Responsibilities</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <?php foreach (explode("\n", $job['application']) as $item): ?>
                                <li><?= htmlspecialchars(trim($item)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Qualifications -->
                <?php if (!empty($job['qualifications'])): ?>
                    <div class="bg-white shadow-md p-6">
                        <h3 class="text-xl font-semibold mb-3">Qualifications</h3>
                        <p class="text-gray-700"><?= htmlspecialchars($job['qualifications']) ?></p>
                    </div>
                <?php endif; ?>

                <!-- Benefits -->
                <?php if (!empty($job['benefits'])): ?>
                    <div class="bg-white shadow-md p-6">
                        <h3 class="text-xl font-semibold mb-3">Benefits</h3>
                        <p class="text-gray-700"><?= htmlspecialchars($job['benefits']) ?></p>
                    </div>
                <?php endif; ?>

                <!-- Company Info (Mobile Only) -->
                <?php if (!empty($job['imageUrl']) || !empty($job['companyName'])): ?>
                    <div class="bg-white shadow-md p-6 lg:hidden">
                        <h3 class="text-xl font-semibold mb-4">Company</h3>
                        <div class="flex flex-col items-center text-center">
                            <?php if (!empty($job['imageUrl'])): ?>
                                <img src="<?= htmlspecialchars($job['imageUrl']) ?>" class="w-full max-w-xs h-64 object-cover mb-4  "
                                    alt="<?= htmlspecialchars($job['companyName']) ?>">
                            <?php endif; ?>
                            <p class="font-bold text-2xl text-blue-600"><?= htmlspecialchars($job['companyName']) ?></p>
                            <?php if (!empty($job['location'])): ?>
                                <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($job['location']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- ================= SIDEBAR ================= -->
            <div class="space-y-8">
                <div class="bg-white shadow-md p-6">
                    <?php if (!empty($job['ctc'])): ?>
                        <div class="text-center mb-4">
                            <div class="text-2xl font-bold"><?= htmlspecialchars($job['ctc']) ?></div>
                        </div>
                    <?php endif; ?>

                    <button class="w-full bg-blue-600 text-white py-3 font-semibold mb-3 hover:bg-blue-700 transition">
                        Apply Now
                    </button>

                    <div class="border-t pt-4 text-sm space-y-2">
                        <?php if (!empty($job['experience'])): ?>
                            <div class="flex justify-between">
                                <span>Experience</span>
                                <span><?= htmlspecialchars($job['experience']) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($job['ageRange'])): ?>
                            <div class="flex justify-between">
                                <span>Age Range</span>
                                <span><?= htmlspecialchars($job['ageRange']) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($job['noticePeriod'])): ?>
                            <div class="flex justify-between">
                                <span>Notice Period</span>
                                <span><?= htmlspecialchars($job['noticePeriod']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Company Info (Desktop Only) -->
                <?php if (!empty($job['imageUrl']) || !empty($job['companyName'])): ?>
                    <div class="bg-white shadow-md p-6 hidden lg:block">
                        <h3 class="text-xl font-semibold mb-4">Company</h3>
                        <div class="text-center">
                            <?php if (!empty($job['imageUrl'])): ?>
                                <img src="<?= htmlspecialchars($job['imageUrl']) ?>" class="w-full h-80 object-cover mb-4   mx-auto"
                                    alt="<?= htmlspecialchars($job['companyName']) ?>">
                            <?php endif; ?>
                            <p class="font-bold text-2xl text-blue-600"><?= htmlspecialchars($job['companyName']) ?></p>
                            <?php if (!empty($job['location'])): ?>
                                <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($job['location']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>