<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);
function navActive(array $pages)
{
    $current = basename($_SERVER['PHP_SELF']);
    return in_array($current, $pages)
        ? 'text-primary-600 bg-primary-50 border-b-2 border-primary-600'
        : 'text-secondary-700 hover:text-primary-600 hover:bg-primary-50';
}

// Include required files
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../config/database.php';

// Get base URL for proper asset paths
$baseUrl = getBaseUrl();

// Check if user is logged in and get user info
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
$userRole = $isLoggedIn ? $_SESSION['user_role'] : '';
$userInitial = $isLoggedIn ? substr($_SESSION['user_name'], 0, 1) : 'U';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - Airigojobs' : 'Airigojobs - Find Your Dream Job'; ?>
    </title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="<?php echo isset($pageDescription) ? htmlspecialchars($pageDescription) : 'Find your dream job in airline and hospitality industry with Airigojobs. Connect with top employers and discover thousands of opportunities.'; ?>">
    <meta name="keywords"
        content="jobs, airline jobs, hospitality jobs, pilot jobs, flight attendant, airport jobs, career">
    <meta name="author" content="Airigojobs">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title"
        content="<?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - Airigojobs' : 'Airigojobs - Find Your Dream Job'; ?>">
    <meta property="og:description"
        content="<?php echo isset($pageDescription) ? htmlspecialchars($pageDescription) : 'Find your dream job in airline and hospitality industry'; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo getCurrentPageUrl(); ?>">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        },
                        secondary: {
                            50: '#f8fafc',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b'
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    boxShadow: {
                        'nav': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                        'dropdown': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                        'card': '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
                    },
                    animation: {
                        'fadeIn': 'fadeIn 0.3s ease-in-out',
                        'slideDown': 'slideDown 0.3s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous">

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/assets/css/custom.css">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo $baseUrl; ?>/assets/images/favicon.ico">

    <!-- Security Headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
</head>

<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-nav sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <!-- Logo -->
                <a href="<?php echo $baseUrl; ?>/" class="flex items-center space-x-3 group">
                    <div
                        class="w-20 h-12 rounded-lg bg-gradient-to-br from-primary-100 to-primary-300 flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 overflow-hidden">
                        <img src="<?php echo $baseUrl; ?>/assets/logos/Airigo jobs logo Trnsp.png" alt="AirigoJobs Logo"
                            class="w-16 h-16 object-contain" />
                    </div>

                    <div class="flex flex-col">
                        <span class="text-2xl font-bold text-primary-700 leading-tight">
                            Airigo<span class="text-secondary-800">jobs</span>
                        </span>
                        <span class="text-xs text-secondary-600 font-medium -mt-1">
                            Airline & Hospitality Careers
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <?php if (!$isLoggedIn): ?>
                        <!-- Public Navigation -->
                        <a href="<?php echo $baseUrl; ?>/" class="px-4 py-3 font-medium transition-all duration-200 flex items-center space-x-2 group
                            <?= navActive(['index.php']) ?>">
                            <i class="fas fa-home text-lg opacity-70 group-hover:opacity-100"></i>
                            <span>Home</span>
                        </a>
                        <a href="<?php echo $baseUrl; ?>/browse-jobs.php" class="px-4 py-3 font-medium transition-all duration-200 flex items-center space-x-2 group
                            <?= navActive(['browse-jobs.php']) ?>">
                            <i class="fas fa-briefcase text-lg opacity-70 group-hover:opacity-100"></i>
                            <span>Browse Jobs</span>
                        </a>
                        <a href="<?php echo $baseUrl; ?>/job-search.php" class="px-4 py-3 font-medium transition-all duration-200 flex items-center space-x-2 group
                            <?= navActive(['job-search.php']) ?>">
                            <i class="fas fa-search text-lg opacity-70 group-hover:opacity-100"></i>
                            <span>Search Jobs</span>
                        </a>
                        <?php if (!$isLoggedIn): ?>
                            <a href="<?php echo $baseUrl; ?>/companies.php" class="px-4 py-3 font-medium transition-all duration-200 flex items-center space-x-2 group
                                <?= navActive(['companies.php']) ?>">
                                <i class="fas fa-building text-lg opacity-70 group-hover:opacity-100"></i>
                                <span>Companies</span>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo $baseUrl; ?>/company-profile.php"
                                class="px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 flex items-center space-x-2 group">
                                <i class="fas fa-building text-lg opacity-70 group-hover:opacity-100"></i>
                                <span>Companies</span>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo $baseUrl; ?>/about.php" class="px-4 py-3 font-medium transition-all duration-200 flex items-center space-x-2 group
                                <?= navActive(['about.php']) ?>"><i
                                class="fas fa-info-circle text-lg opacity-70 group-hover:opacity-100"></i>
                            <span>About</span>
                        </a>

                        <!-- Auth Buttons -->
                        <div class="flex items-center space-x-3 ml-4 pl-4 border-l border-gray-200">
                            <a href="<?php echo $baseUrl; ?>/login.php"
                                class="px-5 py-2.5 text-primary-600 hover:text-primary-700 font-medium transition-all duration-200 hover:bg-primary-50 border border-primary-100">
                                Login
                            </a>
                            <a href="<?php echo $baseUrl; ?>/register.php?type=jobseeker"
                                class="px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-medium hover:from-primary-700 hover:to-primary-800 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                Sign Up Free
                            </a>
                            <a href="https://play.google.com/store/apps/details?id=com.aptitsolutions.airigo"
                                target="_blank"
                                class="flex items-center space-x-1 px-4 py-2.5 bg-black text-white font-medium hover:bg-gray-800 transition-all duration-300">
                                <i class="fab fa-google-play text-lg"></i>
                                <span>App</span>
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Authenticated User Navigation -->
                        <div class="flex items-center space-x-1">
                            <?php if ($userRole == 'jobseeker'): ?>
                                <a href="<?php echo $baseUrl; ?>/dashboard.php"
                                    class="px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 flex items-center space-x-2 group relative">
                                    <i class="fas fa-chart-line text-lg opacity-70 group-hover:opacity-100"></i>
                                    <span>Dashboard</span>
                                </a>
                                <a href="<?php echo $baseUrl; ?>/job-search.php"
                                    class="px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 flex items-center space-x-2 group relative">
                                    <i class="fas fa-search text-lg opacity-70 group-hover:opacity-100"></i>
                                    <span>Find Jobs</span>
                                    <span
                                        class="absolute -top-1 -right-1 bg-primary-500 text-white text-xs px-2 py-0.5 animate-pulse-slow">New</span>
                                </a>
                                <a href="<?php echo $baseUrl; ?>/applications.php"
                                    class="px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 flex items-center space-x-2 group relative">
                                    <i class="fas fa-file-alt text-lg opacity-70 group-hover:opacity-100"></i>
                                    <span>Applications</span>
                                </a>
                                <a href="<?php echo $baseUrl; ?>/profile.php"
                                    class="px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 flex items-center space-x-2 group">
                                    <i class="fas fa-user-circle text-lg opacity-70 group-hover:opacity-100"></i>
                                    <span>Profile</span>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo $baseUrl; ?>/dashboard.php"
                                    class="px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 flex items-center space-x-2 group">
                                    <i class="fas fa-chart-line text-lg opacity-70 group-hover:opacity-100"></i>
                                    <span>Dashboard</span>
                                </a>
                                <a href="<?php echo $baseUrl; ?>/post-job.php"
                                    class="px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 flex items-center space-x-2 group">
                                    <i class="fas fa-plus-circle text-lg opacity-70 group-hover:opacity-100"></i>
                                    <span>Post Job</span>
                                </a>
                                <a href="<?php echo $baseUrl; ?>/manage-jobs.php"
                                    class="px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 flex items-center space-x-2 group">
                                    <i class="fas fa-tasks text-lg opacity-70 group-hover:opacity-100"></i>
                                    <span>Manage Jobs</span>
                                </a>
                                <a href="<?php echo $baseUrl; ?>/candidates.php"
                                    class="px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 flex items-center space-x-2 group">
                                    <i class="fas fa-users text-lg opacity-70 group-hover:opacity-100"></i>
                                    <span>Candidates</span>
                                </a>
                                <a href="<?php echo $baseUrl; ?>/company-profile.php"
                                    class="px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 flex items-center space-x-2 group">
                                    <i class="fas fa-building text-lg opacity-70 group-hover:opacity-100"></i>
                                    <span>Company</span>
                                </a>
                            <?php endif; ?>

                            <!-- User dropdown -->
                            <div class="relative ml-2" id="userDropdown">
                                <button
                                    class="flex items-center space-x-3 px-4 py-2.5 hover:bg-primary-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50"
                                    id="dropdownButton">
                                    <div class="relative">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-semibold shadow-md">
                                            <?php echo strtoupper($userInitial); ?>
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white">
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-start">
                                        <span
                                            class="text-sm font-semibold text-secondary-800"><?php echo htmlspecialchars($userName); ?></span>
                                        <span class="text-xs text-secondary-500 capitalize"><?php echo $userRole; ?></span>
                                    </div>
                                    <i class="fas fa-chevron-down text-secondary-400 text-sm transition-transform duration-200"
                                        id="dropdownIcon"></i>
                                </button>

                                <div class="absolute right-0 mt-2 w-56 bg-white shadow-dropdown py-2 hidden animate-fadeIn z-50 border border-gray-100"
                                    id="dropdownMenu">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-medium text-secondary-800">
                                            <?php echo htmlspecialchars($userName); ?>
                                        </p>
                                        <p class="text-xs text-secondary-500 mt-1">
                                            <?php echo $_SESSION['user_email'] ?? ''; ?>
                                        </p>
                                    </div>

                                    <a href="<?php echo $baseUrl; ?>/profile.php"
                                        class="flex items-center px-4 py-3 text-secondary-700 hover:bg-primary-50 transition-colors duration-150 group">
                                        <i
                                            class="fas fa-user-circle text-primary-500 w-5 mr-3 group-hover:text-primary-600"></i>
                                        <span>My Profile</span>
                                    </a>

                                    <?php if ($userRole == 'recruiter'): ?>
                                        <a href="<?php echo $baseUrl; ?>/company-profile.php"
                                            class="flex items-center px-4 py-3 text-secondary-700 hover:bg-primary-50 transition-colors duration-150 group">
                                            <i
                                                class="fas fa-building text-primary-500 w-5 mr-3 group-hover:text-primary-600"></i>
                                            <span>Company Profile</span>
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?php echo $baseUrl; ?>/settings.php"
                                        class="flex items-center px-4 py-3 text-secondary-700 hover:bg-primary-50 transition-colors duration-150 group">
                                        <i class="fas fa-cog text-primary-500 w-5 mr-3 group-hover:text-primary-600"></i>
                                        <span>Account Settings</span>
                                    </a>

                                    <div class="border-t border-gray-100 my-2"></div>

                                    <a href="<?php echo $baseUrl; ?>/logout.php"
                                        class="flex items-center px-4 py-3 text-red-600 hover:bg-red-50 transition-colors duration-150 group">
                                        <i class="fas fa-sign-out-alt w-5 mr-3 group-hover:text-red-700"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center space-x-3 lg:hidden">
                    <?php if ($isLoggedIn): ?>
                        <!-- Mobile user icon for logged in -->
                        <div class="relative md:hidden">
                            <div
                                class="w-9 h-9 bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-semibold">
                                <?php echo strtoupper($userInitial); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <button
                        class="text-secondary-700 hover:text-primary-600 focus:outline-none transition-colors duration-200"
                        id="mobileMenuButton">
                        <i class="fas fa-bars text-2xl" id="mobileMenuIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div class="lg:hidden hidden py-4 border-t border-gray-100 animate-slideDown bg-white" id="mobileMenu">
                <?php if (!$isLoggedIn): ?>
                    <!-- Public Mobile Menu -->
                    <div class="space-y-1">
                        <a href="<?php echo $baseUrl; ?>/" class="flex items-center space-x-3 px-4 py-3 transition-colors duration-200 group
                            <?= navActive(['index.php']) ?>">
                            <i
                                class="fas fa-home text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                            <span class="font-medium">Home</span>
                        </a>
                        <a href="<?php echo $baseUrl; ?>/browse-jobs.php" class="flex items-center space-x-3 px-4 py-3 transition-colors duration-200 group
                            <?= navActive(['browse-jobs.php']) ?>">
                            <i
                                class="fas fa-briefcase text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                            <span class="font-medium">Browse Jobs</span>
                        </a>
                        <a href="<?php echo $baseUrl; ?>/job-search.php" class="flex items-center space-x-3 px-4 py-3 transition-colors duration-200 group
                            <?= navActive(['job-search.php']) ?>">
                            <i
                                class="fas fa-search text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                            <span class="font-medium">Search Jobs</span>
                        </a>
                        <?php if (!$isLoggedIn): ?>
                            <a href="<?php echo $baseUrl; ?>/companies.php" class="flex items-center space-x-3 px-4 py-3 transition-colors duration-200 group
                                <?= navActive(['companies.php']) ?>">
                                <i
                                    class="fas fa-building text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Companies</span>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo $baseUrl; ?>/company-profile.php"
                                class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                                <i
                                    class="fas fa-building text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Companies</span>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo $baseUrl; ?>/about.php" class="flex items-center space-x-3 px-4 py-3 transition-colors duration-200 group
                            <?= navActive(['about.php']) ?>">
                            <i
                                class="fas fa-info-circle text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                            <span class="font-medium">About</span>
                        </a>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
                        <a href="<?php echo $baseUrl; ?>/login.php"
                            class="block px-4 py-3 text-primary-600 hover:text-primary-700 font-medium hover:bg-primary-50 border border-primary-100 transition-colors duration-200 text-center">
                            Login
                        </a>
                        <a href="<?php echo $baseUrl; ?>/register.php?type=jobseeker"
                            class="block px-4 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-medium hover:from-primary-700 hover:to-primary-800 shadow-md transition-all duration-300 text-center">
                            Sign Up Free
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.aptitsolutions.airigo" target="_blank"
                            class="block px-4 py-3 bg-black text-white font-medium hover:bg-gray-800 transition-all duration-300 text-center flex items-center justify-center space-x-2">
                            <i class="fab fa-google-play"></i>
                            <span>Get our App</span>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Authenticated User Mobile Menu -->
                    <div class="space-y-1">
                        <div class="flex items-center space-x-3 px-4 py-3 bg-primary-50 mb-3">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-semibold text-lg">
                                <?php echo strtoupper($userInitial); ?>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-secondary-800"><?php echo htmlspecialchars($userName); ?></p>
                                <p class="text-sm text-secondary-500 capitalize"><?php echo $userRole; ?></p>
                            </div>
                        </div>

                        <?php if ($userRole == 'jobseeker'): ?>
                            <a href="<?php echo $baseUrl; ?>/dashboard.php"
                                class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                                <i
                                    class="fas fa-chart-line text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>
                            <a href="<?php echo $baseUrl; ?>/job-search.php"
                                class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                                <i
                                    class="fas fa-search text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Find Jobs</span>
                                <span class="ml-auto bg-primary-500 text-white text-xs px-2 py-1 animate-pulse-slow">New</span>
                            </a>
                            <a href="<?php echo $baseUrl; ?>/applications.php"
                                class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                                <i
                                    class="fas fa-file-alt text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Applications</span>
                            </a>
                            <a href="<?php echo $baseUrl; ?>/profile.php"
                                class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                                <i
                                    class="fas fa-user-circle text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Profile</span>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo $baseUrl; ?>/dashboard.php"
                                class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                                <i
                                    class="fas fa-chart-line text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>
                            <a href="<?php echo $baseUrl; ?>/post-job.php"
                                class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                                <i
                                    class="fas fa-plus-circle text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Post Job</span>
                            </a>
                            <a href="<?php echo $baseUrl; ?>/manage-jobs.php"
                                class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                                <i
                                    class="fas fa-tasks text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Manage Jobs</span>
                            </a>
                            <a href="<?php echo $baseUrl; ?>/candidates.php"
                                class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                                <i
                                    class="fas fa-users text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Candidates</span>
                            </a>
                            <a href="<?php echo $baseUrl; ?>/company-profile.php"
                                class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                                <i
                                    class="fas fa-building text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                                <span class="font-medium">Company</span>
                            </a>
                        <?php endif; ?>

                        <a href="<?php echo $baseUrl; ?>/settings.php"
                            class="flex items-center space-x-3 px-4 py-3 text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 group">
                            <i class="fas fa-cog text-lg w-6 text-center text-primary-500 group-hover:text-primary-600"></i>
                            <span class="font-medium">Settings</span>
                        </a>

                        <div class="border-t border-gray-200 my-2"></div>

                        <a href="<?php echo $baseUrl; ?>/logout.php"
                            class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors duration-200 group">
                            <i class="fas fa-sign-out-alt text-lg w-6 text-center group-hover:text-red-700"></i>
                            <span class="font-medium">Logout</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="min-h-screen">

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const mobileMenuButton = document.getElementById('mobileMenuButton');
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileMenuIcon = document.getElementById('mobileMenuIcon');

                let isMobileMenuOpen = false;

                if (mobileMenuButton && mobileMenu) {
                    mobileMenuButton.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();

                        isMobileMenuOpen = !isMobileMenuOpen;

                        if (isMobileMenuOpen) {
                            mobileMenu.classList.remove('hidden');
                            mobileMenuIcon.classList.remove('fa-bars');
                            mobileMenuIcon.classList.add('fa-times');
                        } else {
                            mobileMenu.classList.add('hidden');
                            mobileMenuIcon.classList.remove('fa-times');
                            mobileMenuIcon.classList.add('fa-bars');
                        }
                    });
                }

                // Close menu when clicking outside
                document.addEventListener('click', function (e) {
                    if (
                        isMobileMenuOpen &&
                        !mobileMenu.contains(e.target) &&
                        !mobileMenuButton.contains(e.target)
                    ) {
                        isMobileMenuOpen = false;
                        mobileMenu.classList.add('hidden');
                        mobileMenuIcon.classList.remove('fa-times');
                        mobileMenuIcon.classList.add('fa-bars');
                    }
                });

                // Close menu when clicking any mobile link
                document.querySelectorAll('#mobileMenu a').forEach(link => {
                    link.addEventListener('click', () => {
                        isMobileMenuOpen = false;
                        mobileMenu.classList.add('hidden');
                        mobileMenuIcon.classList.remove('fa-times');
                        mobileMenuIcon.classList.add('fa-bars');
                    });
                });

                /* ---------- USER DROPDOWN ---------- */

                const dropdownButton = document.getElementById('dropdownButton');
                const dropdownMenu = document.getElementById('dropdownMenu');
                const dropdownIcon = document.getElementById('dropdownIcon');

                if (dropdownButton && dropdownMenu) {
                    dropdownButton.addEventListener('click', function (e) {
                        e.stopPropagation();
                        dropdownMenu.classList.toggle('hidden');
                        dropdownIcon.classList.toggle('rotate-180');
                    });

                    document.addEventListener('click', function () {
                        dropdownMenu.classList.add('hidden');
                        dropdownIcon.classList.remove('rotate-180');
                    });
                }
            });
        </script>

        <style>
            /* Additional custom styles */
            .rotate-180 {
                transform: rotate(180deg);
            }

            /* Smooth transitions */
            * {
                transition: background-color 0.2s ease, border-color 0.2s ease;
            }

            /* Improve readability */
            .font-sans {
                font-feature-settings: "kern" 1, "liga" 1, "calt" 1;
            }
        </style>