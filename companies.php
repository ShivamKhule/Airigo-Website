<?php
$pageTitle = "Companies";
require_once 'includes/header.php';
require_once 'config/firestore-db.php';

$db = new FirestoreDB();

// Get all jobs to extract unique company names
$allJobs = $db->getJobs([], 1000); // Get all jobs

// Extract unique companies from jobs
$companiesMap = [];
foreach ($allJobs as $job) {
    $companyName = $job['companyName'] ?? 'Unknown Company';
    if (!isset($companiesMap[$companyName])) {
        $companiesMap[$companyName] = [
            'name' => $companyName,
            'jobs' => [],
            'logo' => $job['imageUrl'] ?? 'https://via.placeholder.com/200x200?text=No+Image',
            'industry' => $job['category'] ?? 'N/A',
            'location' => $job['location'] ?? 'N/A',
            'description' => 'Leading company in the airline and hospitality industry',
            'contact' => 'N/A',
            'email' => 'N/A'
        ];
    }
    $companiesMap[$companyName]['jobs'][] = $job;
}

// Convert to the format we need
$companies = [];
foreach ($companiesMap as $companyName => $companyData) {
    $companies[] = [
        'id' => md5($companyName), // Generate a unique ID
        'name' => $companyData['name'],
        'logo' => $companyData['logo'],
        'industry' => $companyData['industry'],
        'size' => 'N/A',
        'location' => $companyData['location'],
        'description' => $companyData['description'],
        'jobs_count' => count($companyData['jobs']),
        'website' => 'N/A',
        'founded' => 'N/A',
        'contact' => $companyData['contact'],
        'email' => $companyData['email']
    ];
}
?>

<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="container mx-auto px-4">
        <div class="bg-white shadow-md p-6 my-8 justify-start items-start">
            <h1 class="text-2xl md:text-3xl font-bold mb-4">Top Companies</h1>
            <h2 class="text-lg md:text-xl mb-8 max-w-3xl opacity-90">
                Discover opportunities with leading companies in airline and hospitality
            </h2>
            <div class="max-w-2xl">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search companies by name, industry, or location..."
                        class="w-full px-4 py-3 pl-12 border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        id="companySearch">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo count($companies); ?></div>
                    <p class="text-gray-600">Companies</p>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">
                        <?php
                        $totalJobs = 0;
                        foreach ($companies as $company) {
                            $totalJobs += $company['jobs_count'];
                        }
                        echo $totalJobs;
                        ?>
                    </div>
                    <p class="text-gray-600">Active Jobs</p>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">2</div>
                    <p class="text-gray-600">Industries</p>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">3</div>
                    <p class="text-gray-600">Countries</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Companies Filter -->
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 md:mb-0">Browse Companies</h2>
                <div class="flex flex-wrap gap-3">
                    <button
                        class="px-4 py-2 border border-gray-300 text-gray-700   hover:bg-blue-50 hover:border-blue-500 hover:text-blue-600 transition duration-300">
                        All Industries
                    </button>
                    <button
                        class="px-4 py-2 border border-gray-300 text-gray-700   hover:bg-blue-50 hover:border-blue-500 hover:text-blue-600 transition duration-300">
                        Airline
                    </button>
                    <button
                        class="px-4 py-2 border border-gray-300 text-gray-700   hover:bg-blue-50 hover:border-blue-500 hover:text-blue-600 transition duration-300">
                        Hospitality
                    </button>
                    <button
                        class="px-4 py-2 border border-gray-300 text-gray-700   hover:bg-blue-50 hover:border-blue-500 hover:text-blue-600 transition duration-300">
                        Aviation
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Companies Grid -->
    <section class="pb-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <?php if (empty($companies)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-building text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Companies Found</h3>
                    <p class="text-gray-500">There are currently no companies listed in our database.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="companiesGrid">
                    <?php foreach ($companies as $company): ?>
                        <div class="bg-white   shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                            <div class="p-6">
                                <div class="flex items-start">
                                    <img src="<?php echo $company['logo']; ?>"
                                        alt="<?php echo htmlspecialchars($company['name']); ?>"
                                        class="w-16 h-16   object-cover mr-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-900 mb-1">
                                            <?php echo htmlspecialchars($company['name']); ?>
                                        </h3>
                                        <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($company['industry']); ?></p>
                                        <p class="text-gray-600 mb-2">Contact:
                                            <?php echo htmlspecialchars($company['contact']); ?>
                                        </p>
                                        <div class="flex items-center text-gray-500 text-sm">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            <span><?php echo htmlspecialchars($company['location']); ?></span>
                                        </div>
                                        <div class="flex items-center text-gray-500 text-sm mt-1">
                                            <i class="fas fa-envelope mr-1"></i>
                                            <span><?php echo htmlspecialchars($company['email']); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-gray-700 mt-4 mb-6"><?php echo htmlspecialchars($company['description']); ?></p>

                                <div class="text-sm text-gray-600 mb-4">
                                    <p><strong>Company:</strong> <?php echo htmlspecialchars($company['name']); ?></p>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600">
                                        <i class="fas fa-briefcase mr-1"></i>
                                        <?php echo $company['jobs_count']; ?> open
                                        position<?php echo $company['jobs_count'] != 1 ? 's' : ''; ?>
                                    </div>
                                    <?php if ($isLoggedIn && $userRole === 'recruiter' && $company['email'] === $_SESSION['user_email']): ?>
                                        <a href="company-profile.php" class="text-blue-600 hover:text-blue-800 font-medium">
                                            View Details <i class="fas fa-arrow-right ml-1 text-sm"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="job-search.php?company=<?php echo urlencode($company['name']); ?>"
                                            class="text-blue-600 hover:text-blue-800 font-medium">
                                            View Jobs <i class="fas fa-arrow-right ml-1 text-sm"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Load More Button -->
            <div class="text-center mt-12">
                <button
                    class="bg-blue-600 text-white px-8 py-4   font-medium hover:bg-blue-700 transition duration-300">
                    Load More Companies
                </button>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Are you a company looking to hire?</h2>
            <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                Join thousands of companies that have found top talent through Airigojobs
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="register.php?type=recruiter"
                    class="bg-white text-blue-700 px-10 py-4   font-bold text-lg hover:bg-gray-100 transition duration-300">
                    Post Jobs Now
                </a>
                <a href="contact.php"
                    class="bg-transparent border-2 border-white text-white px-10 py-4   font-bold text-lg hover:bg-white hover:text-blue-700 transition duration-300">
                    Contact Sales
                </a>
            </div>
        </div>
    </section>
</div>

<script>
    // Search functionality
    document.getElementById('companySearch').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const companies = document.querySelectorAll('#companiesGrid > div');

        companies.forEach(company => {
            const companyName = company.querySelector('h3').textContent.toLowerCase();
            const companyIndustry = company.querySelectorAll('p')[0].textContent.toLowerCase();
            const companyLocation = company.querySelector('.text-gray-500').textContent.toLowerCase();

            if (companyName.includes(searchTerm) ||
                companyIndustry.includes(searchTerm) ||
                companyLocation.includes(searchTerm)) {
                company.style.display = 'block';
            } else {
                company.style.display = 'none';
            }
        });
    });

    // Filter functionality
    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', function () {
            // Remove active class from all buttons
            document.querySelectorAll('button').forEach(btn => {
                btn.classList.remove('bg-blue-50', 'border-blue-500', 'text-blue-600');
            });

            // Add active class to clicked button
            this.classList.add('bg-blue-50', 'border-blue-500', 'text-blue-600');
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>