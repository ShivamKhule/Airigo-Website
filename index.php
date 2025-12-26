<?php
require_once __DIR__ . '/config/firestore-db.php';

$db = new FirestoreDB();

// Get featured jobs from Firestore
$featuredJobs = $db->getJobs(['isActive' => true], 6);

// Add proper IDs to jobs
$jobsWithIds = [];
foreach ($featuredJobs as $index => $job) {
    $job['id'] = $job['id'] ?? 'job' . ($index + 1);
    $jobsWithIds[] = $job;
}
$featuredJobs = $jobsWithIds;

$pageTitle = "Find Your Dream Job";

$stats = [
    'total_jobs' => count($db->getJobs(['isActive' => true], 1000)),
    'total_companies' => 50,
    'total_seekers' => 1000,
];

// Define features data (easy to modify or fetch from DB later)
$features = [
    [
        'title' => 'Smart Job Matching',
        'description' => 'Our AI-powered algorithm matches you with the most relevant opportunities based on your skills and preferences.',
        'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', // search icon
        'color' => 'blue'
    ],
    [
        'title' => 'Instant Applications',
        'description' => 'Apply to multiple jobs with a single click. Your profile and resume are always ready to go.',
        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', // clock
        'color' => 'purple'
    ],
    [
        'title' => 'Real-time Tracking',
        'description' => 'Track your applications in real-time. Get instant notifications when recruiters view your profile.',
        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', // check circle
        'color' => 'green'
    ],
    [
        'title' => 'Advanced Filters',
        'description' => 'Filter by salary, location, experience level, and more to find exactly what you\'re looking for.',
        'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4',
        'color' => 'yellow'
    ],
    [
        'title' => 'Insightful Analytics',
        'description' => 'Get detailed insights about your job search or recruiting performance with our analytics dashboard.',
        'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        'color' => 'cyan'
    ],
    [
        'title' => 'Secure & Private',
        'description' => 'Your data is protected with enterprise-grade security. We never share your information without consent.',
        'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
        'color' => 'red'
    ]
];

// Tailwind color mapping for icons and backgrounds
$colorClasses = [
    'blue' => 'bg-blue-100 text-blue-600',
    'purple' => 'bg-purple-100 text-purple-600',
    'green' => 'bg-green-100 text-green-600',
    'yellow' => 'bg-yellow-100 text-yellow-600',
    'cyan' => 'bg-cyan-100 text-cyan-600',
    'red' => 'bg-red-100 text-red-600'
];

$gradientClasses = [
    'blue' => 'from-blue-500 to-blue-400',
    'purple' => 'from-purple-500 to-purple-400',
    'green' => 'from-green-500 to-green-400',
    'yellow' => 'from-yellow-500 to-yellow-400',
    'cyan' => 'from-cyan-500 to-cyan-400',
    'red' => 'from-red-500 to-red-400'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo $baseUrl; ?>/assets/images/favicon.ico">
    <!-- Other head content if needed -->
</head>

<body>
    <?php require_once 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="relative bg-slate-50 overflow-hidden" data-testid="hero-section">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-16 lg:py-24">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <!-- Left: Content -->
                <div class="space-y-8">

                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[hsl(217,91%,60%)]/10  ">
                        <span class="text-[hsl(217,91%,60%)] text-sm font-medium">
                            Over <?php echo $stats['total_jobs']; ?>+ jobs available
                        </span>
                    </div>

                    <!-- Heading -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-[hsl(222,47%,11%)] leading-tight">
                        Find Your <span class="text-[hsl(217,91%,60%)]">Dream Job</span> Today
                    </h1>

                    <!-- Description -->
                    <p class="text-lg text-slate-600 max-w-lg">
                        Connect with top employers and discover opportunities that match your skills and aspirations.
                        Your next career move starts here.
                    </p>

                    <!-- Search Box -->
                    <form action="job-search.php" method="GET" class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="keyword" placeholder="Job title, company, or keywords"
                                class="pl-12 h-14 w-full   border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none text-base"
                                data-testid="hero-search-input" />
                        </div>
                        <button type="submit"
                            class="h-14 px-8   text-white bg-[hsl(217,91%,60%)] hover:bg-[hsl(217,91%,50%)] transition"
                            data-testid="hero-search-btn">
                            Search Jobs
                        </button>
                    </form>

                    <!-- Stats -->
                    <div class="flex flex-wrap gap-8 pt-4">
                        <div>
                            <p class="text-3xl font-bold text-[hsl(222,47%,11%)]">
                                <?php echo $stats['total_jobs']; ?>+
                            </p>
                            <p class="text-slate-600">Active Jobs</p>
                        </div>

                        <div>
                            <p class="text-3xl font-bold text-[hsl(222,47%,11%)]">
                                <?php echo $stats['total_companies']; ?>+
                            </p>
                            <p class="text-slate-600">Companies</p>
                        </div>

                        <div>
                            <p class="text-3xl font-bold text-[hsl(222,47%,11%)]">
                                <?php echo $stats['total_seekers']; ?>+
                            </p>
                            <p class="text-slate-600">Job Seekers</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Image Grid -->
                <div class="hidden lg:grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img src="https://images.unsplash.com/photo-1758873268631-fa944fc5cad2?w=400&h=300&fit=crop"
                            alt="Team collaborating" class="  w-full h-48 object-cover" />
                        <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=400&h=200&fit=crop"
                            alt="Office workspace" class="  w-full h-32 object-cover" />
                    </div>

                    <div class="space-y-4 pt-8">
                        <img src="https://images.unsplash.com/photo-1758691737217-77302c5f988f?w=400&h=200&fit=crop"
                            alt="Professional meeting" class="  w-full h-32 object-cover" />
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400&h=300&fit=crop"
                            alt="Team success" class="  w-full h-48 object-cover" />
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Job Categories -->
    <section class="py-20 bg-gradient-to-b from-slate-200 to-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-14 text-gray-800">
                Browse Jobs by Category
            </h2>

            <!-- Two-column premium layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto">
                <?php
                $categories = [
                    [
                        'icon' => 'fa-plane',
                        'title' => 'Airline Jobs',
                        'url_hint' => 'Airline',
                        'jobs' => '245',
                        'gradient' => 'from-blue-500 to-indigo-500',
                        'soft' => 'bg-blue-50 text-blue-600'
                    ],
                    [
                        'icon' => 'fa-hotel',
                        'title' => 'Hospitality',
                        'url_hint' => 'Hospitality',
                        'jobs' => '189',
                        'gradient' => 'from-emerald-500 to-teal-500',
                        'soft' => 'bg-emerald-50 text-emerald-600'
                    ]
                ];

                foreach ($categories as $category):
                    ?>
                    <a href="<?php echo $baseUrl; ?>/job-search.php?category=<?php echo urlencode($category['url_hint']); ?>"
                        class="group relative overflow-hidden   border border-gray-200 bg-white p-8 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">

                        <!-- Shimmer overlay -->
                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent 
                             -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>

                        <div class="relative z-10 flex items-start justify-between">
                            <div>
                                <!-- Icon -->
                                <div class="<?php echo $category['soft']; ?> w-16 h-16   flex items-center justify-center mb-6
                                    transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                                    <i class="fas <?php echo $category['icon']; ?> text-2xl"></i>
                                </div>

                                <!-- Content -->
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">
                                    <?php echo $category['title']; ?>
                                </h3>
                                <p class="text-gray-600 mb-6">
                                    <?php echo $category['jobs']; ?> active openings
                                </p>

                                <!-- CTA -->
                                <div class="inline-flex items-center font-semibold text-white px-5 py-2.5  
                                    bg-gradient-to-r <?php echo $category['gradient']; ?>
                                    transition-all duration-300 group-hover:gap-3">
                                    View Jobs
                                    <i class="mx-2 fas fa-arrow-right text-sm"></i>
                                </div>
                            </div>

                            <!-- Decorative glow -->
                            <div class="absolute -right-10 -bottom-10 w-40 h-40   opacity-20 blur-3xl
                                bg-gradient-to-r <?php echo $category['gradient']; ?>"></div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <!-- Section Header -->
            <div class="text-center mb-12 md:mb-20 max-w-3xl mx-auto">
                <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold   bg-blue-100 text-blue-700">
                    Why Choose Us
                </span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Everything you need to succeed
                </h2>
                <p class="text-lg md:text-xl text-gray-600">
                    Powerful tools and features designed to make your job search or hiring process seamless and
                    effective.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <?php foreach ($features as $feature): ?>
                    <div
                        class="group relative bg-white shadow-lg hover:shadow-2xl transition-all duration-500 p-6 md:p-8 overflow-hidden">
                        <!-- Gradient overlay on hover -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none <?php echo $gradientClasses[$feature['color']]; ?>">
                        </div>

                        <!-- Content (with relative + higher z-index to stay on top) -->
                        <div class="relative z-10">
                            <div
                                class="w-12 h-12 md:w-14 md:h-14 <?php echo $colorClasses[$feature['color']]; ?> flex items-center justify-center mb-6 transition-transform group-hover:scale-110 duration-300">
                                <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="<?php echo $feature['icon']; ?>" />
                                </svg>
                            </div>

                            <h3
                                class="text-xl md:text-2xl font-bold text-gray-900 mb-3 group-hover:text-white transition-colors duration-300">
                                <?php echo htmlspecialchars($feature['title']); ?>
                            </h3>

                            <p
                                class="text-gray-600 text-base md:text-lg group-hover:text-white/90 transition-colors duration-300">
                                <?php echo htmlspecialchars($feature['description']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12 md:mb-20 max-w-3xl mx-auto">
                <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold   bg-blue-100 text-blue-700">
                    How Airigojobs Works
                </span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Making things easier for you
                </h2>
                <p class="text-lg md:text-xl text-gray-600">
                    Every user should know, how to use our platform. It's designed to make your job search or hiring process easier.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-20 h-20   flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-plus text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">1. Create Your Profile</h3>
                    <p class="text-gray-600">Sign up as a job seeker or employer and create your detailed profile.</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 w-20 h-20   flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">2. Find or Post Jobs</h3>
                    <p class="text-gray-600">Job seekers search for opportunities, employers post job vacancies.</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 w-20 h-20   flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-handshake text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">3. Connect & Hire</h3>
                    <p class="text-gray-600">Apply for jobs, communicate, and get hired for your dream position.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Jobs -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Featured Jobs</h2>
                <a href="<?php echo $baseUrl; ?>/job-search.php"
                    class="text-blue-600 hover:text-blue-800 font-semibold">
                    View All Jobs <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (!empty($featuredJobs)): ?>
                    <?php foreach ($featuredJobs as $job): ?>
                        <div class="border border-gray-200   p-6 hover:border-blue-500 hover:shadow-lg transition duration-300">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center">
                                    <?php if (!empty($job['imageUrl'])): ?>
                                        <img src="<?php echo htmlspecialchars($job['imageUrl']); ?>"
                                            alt="<?php echo htmlspecialchars($job['companyName']); ?>"
                                            class="w-12 h-12   object-cover mr-4">
                                    <?php else: ?>
                                        <div class="w-12 h-12 bg-blue-100   flex items-center justify-center mr-4">
                                            <i class="fas fa-building text-blue-600"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800">
                                            <?php echo htmlspecialchars($job['designation']); ?>
                                        </h3>
                                        <p class="text-gray-600"><?php echo htmlspecialchars($job['companyName']); ?></p>
                                    </div>
                                </div>
                                <?php if ($job['isUrgentHiring']): ?>
                                    <span class="bg-red-100 text-red-600 text-xs font-semibold px-3 py-1  ">URGENT</span>
                                <?php endif; ?>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                                    <span><?php echo htmlspecialchars($job['location']); ?></span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-briefcase mr-2 text-blue-500"></i>
                                    <span><?php echo htmlspecialchars($job['jobType']); ?></span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-money-bill-wave mr-2 text-blue-500"></i>
                                    <span><?php echo htmlspecialchars($job['ctc']); ?></span>
                                </div>
                            </div>

                            <a href="<?php echo $baseUrl; ?>/job-details.php?id=<?php echo $job['id']; ?>"
                                class="block w-full bg-blue-600 text-white text-center py-3   hover:bg-blue-700 font-medium transition duration-300">
                                View Details
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-500">No featured jobs available at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <!-- <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Success Stories</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8   shadow-lg">
                    <div class="flex items-center mb-6">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100&h=100&fit=crop&crop=face"
                            alt="Sarah Johnson" class="w-16 h-16   mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Sarah Johnson</h4>
                            <p class="text-gray-600">Senior Pilot at Airigo</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-4">"Airigojobs helped me land my dream job as a senior pilot. The
                        platform connected me with the right opportunities and made the application process seamless."
                    </p>
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="bg-white p-8   shadow-lg">
                    <div class="flex items-center mb-6">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face"
                            alt="Michael Chen" class="w-16 h-16   mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Michael Chen</h4>
                            <p class="text-gray-600">HR Manager at SkyJet</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-4">"As a recruiter, Airigojobs has been invaluable for finding
                        qualified candidates. The platform's filtering tools help us find the perfect fit for every
                        position."</p>
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="bg-white p-8   shadow-lg">
                    <div class="flex items-center mb-6">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face"
                            alt="Maria Rodriguez" class="w-16 h-16   mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Maria Rodriguez</h4>
                            <p class="text-gray-600">Flight Attendant</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-4">"I found my current position through Airigojobs. The job alerts
                        feature kept me updated on new opportunities, and the application tracking was very helpful."
                    </p>
                    <div class="text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Success Stories / Testimonials Infinite Continuous Scrolling Marquee -->
    <section class="py-20 bg-gray-50 overflow-hidden">
        <div class="container mx-auto px-4 pb-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Success Stories</h2>
                <p class="mt-4 text-lg text-gray-600">Hear from professionals who found their dream roles through
                    Airigojobs</p>
            </div>

            <!-- Infinite Scrolling Container -->
            <div class="relative overflow-hidden group">
                <!-- Fade edges for better look -->
                <div
                    class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none">
                </div>
                <div
                    class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none">
                </div>

                <!-- Scrolling Track -->
                <div class="flex animate-marquee-infinite space-x-8">
                    <?php
                    // Define testimonials as a PHP array for easy maintenance and future DB integration
                    $testimonials = [
                        [
                            'name' => 'Sarah Johnson',
                            'role' => 'Senior Pilot at Airigo',
                            'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100&h=100&fit=crop&crop=face',
                            'quote' => "Airigojobs helped me land my dream job as a senior pilot. The platform connected me with the right opportunities and made the application process seamless.",
                            'rating' => 5
                        ],
                        [
                            'name' => 'Michael Chen',
                            'role' => 'HR Manager at SkyJet',
                            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face',
                            'quote' => "As a recruiter, Airigojobs has been invaluable for finding qualified candidates. The platform's filtering tools help us find the perfect fit for every position.",
                            'rating' => 5
                        ],
                        [
                            'name' => 'Maria Rodriguez',
                            'role' => 'Flight Attendant',
                            'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face',
                            'quote' => "I found my current position through Airigojobs. The job alerts feature kept me updated on new opportunities, and the application tracking was very helpful.",
                            'rating' => 4.5
                        ],
                        [
                            'name' => 'Sarah Johnson',
                            'role' => 'Senior Pilot at Airigo',
                            'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100&h=100&fit=crop&crop=face',
                            'quote' => "Airigojobs helped me land my dream job as a senior pilot. The platform connected me with the right opportunities and made the application process seamless.",
                            'rating' => 5
                        ],
                        [
                            'name' => 'Michael Chen',
                            'role' => 'HR Manager at SkyJet',
                            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face',
                            'quote' => "As a recruiter, Airigojobs has been invaluable for finding qualified candidates. The platform's filtering tools help us find the perfect fit for every position.",
                            'rating' => 5
                        ],
                        [
                            'name' => 'Maria Rodriguez',
                            'role' => 'Flight Attendant',
                            'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face',
                            'quote' => "I found my current position through Airigojobs. The job alerts feature kept me updated on new opportunities, and the application tracking was very helpful.",
                            'rating' => 4.5
                        ]
                        // Add more testimonials here if needed
                    ];

                    // Render each testimonial card (duplicated for seamless loop)
                    foreach (array_merge($testimonials, $testimonials) as $testimonial): ?>
                        <div class="flex-shrink-0 w-1/3">
                            <div class="bg-white shadow-xl p-4 h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-center mb-6">
                                        <img src="<?php echo $testimonial['image']; ?>"
                                            alt="<?php echo htmlspecialchars($testimonial['name']); ?>"
                                            class="w-24 h-24 rounded-full object-cover border-4 border-blue-100">
                                    </div>
                                    <p class="text-gray-700 text-lg italic mb-6 leading-relaxed text-center">
                                        "<?php echo htmlspecialchars($testimonial['quote']); ?>"
                                    </p>
                                </div>
                                <div class="text-center">
                                    <h4 class="font-bold text-xl text-gray-800">
                                        <?php echo htmlspecialchars($testimonial['name']); ?>
                                    </h4>
                                    <p class="text-gray-600"><?php echo htmlspecialchars($testimonial['role']); ?></p>
                                    <div class="flex justify-center mt-4 text-yellow-400 text-xl">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i
                                                class="fas <?php echo $i <= floor($testimonial['rating']) ? 'fa-star' : ($i - 0.5 == $testimonial['rating'] ? 'fa-star-half-alt' : 'fa-star'); ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Custom Animation Styles (add to your main CSS or Tailwind config) -->
        <style>
            @keyframes marquee-infinite {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            .animate-marquee-infinite {
                animation: marquee-infinite 40s linear infinite;
            }

            /* Pause on hover for better accessibility */
            .group:hover .animate-marquee-infinite {
                animation-play-state: paused;
            }
        </style>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-700 to-blue-900 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Start Your Career Journey?</h2>
            <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">Join thousands of job seekers and employers who have
                found
                success with Airigojobs.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="<?php echo $baseUrl; ?>/register.php?type=jobseeker"
                    class="bg-white text-blue-700 px-10 py-4   font-bold text-lg hover:bg-gray-100 transition duration-300">
                    Find Jobs Now
                </a>
                <a href="<?php echo $baseUrl; ?>/register.php?type=recruiter"
                    class="bg-transparent border-2 border-white text-white px-10 py-4   font-bold text-lg hover:bg-white hover:text-blue-700 transition duration-300">
                    Post Jobs Free
                </a>
            </div>
        </div>
    </section>

</body>

<?php require_once 'includes/footer.php'; ?>