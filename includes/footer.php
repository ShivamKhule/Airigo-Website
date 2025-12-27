</main>

<!-- Footer -->
<footer class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <!-- Logo -->
                <a href="<?php echo $baseUrl; ?>/" class="flex items-center space-x-3 group">
                    <div
                        class="w-20 h-12 rounded-lg bg-gradient-to-br from-primary-100 to-primary-100 flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 overflow-hidden">
                        <img src="<?php echo $baseUrl; ?>/assets/logos/Airigo jobs logo Trnsp.png" alt="AirigoJobs Logo"
                            class="w-16 h-16 object-contain" />
                    </div>

                    <div class="flex flex-col">
                        <span class="text-2xl font-bold text-primary-700 leading-tight">
                            Airigo<span class="text-secondary-600">jobs</span>
                        </span>
                        <span class="text-xs text-secondary-200 font-medium -mt-1">
                            Airline & Hospitality Careers
                        </span>
                    </div>
                </a>
                <p class="text-gray-400 mb-6 mt-2">
                    Connecting talented professionals with top employers in the airline and hospitality industry.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-gray-800   flex items-center justify-center hover:bg-blue-600">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800   flex items-center justify-center hover:bg-blue-400">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800   flex items-center justify-center hover:bg-blue-700">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.instagram.com/airigojobs/"
                        class="w-10 h-10 bg-gray-800   flex items-center justify-center hover:bg-pink-600">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold mb-6">Quick Links</h3>
                <ul class="space-y-3">
                    <li><a href="<?php echo $baseUrl; ?>/" class="text-gray-400 hover:text-white">Home</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/job-search.php" class="text-gray-400 hover:text-white">Find
                            Jobs</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/about.php" class="text-gray-400 hover:text-white">About Us</a>
                    </li>
                    <li><a href="<?php echo $baseUrl; ?>/contact.php" class="text-gray-400 hover:text-white">Contact
                            Us</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/privacy.php" class="text-gray-400 hover:text-white">Privacy
                            Policy</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/terms.php" class="text-gray-400 hover:text-white">Terms of
                            Service</a></li>
                </ul>
            </div>

            <!-- Job Seekers -->
            <div>
                <h3 class="text-lg font-bold mb-6">For Job Seekers</h3>
                <ul class="space-y-3">
                    <li><a href="<?php echo $baseUrl; ?>/register.php?type=jobseeker"
                            class="text-gray-400 hover:text-white">Create Account</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/job-search.php" class="text-gray-400 hover:text-white">Search
                            Jobs</a></li>
                    <!-- <li><a href="<?php echo $baseUrl; ?>/career-advice.php" class="text-gray-400 hover:text-white">Career Advice</a></li> -->
                    <!-- <li><a href="<?php echo $baseUrl; ?>/resume-tips.php" class="text-gray-400 hover:text-white">Resume Tips</a></li> -->
                    <!-- <li><a href="<?php echo $baseUrl; ?>/interview-prep.php" class="text-gray-400 hover:text-white">Interview Preparation</a></li> -->
                    <li><a href="<?php echo $baseUrl; ?>/faq.php" class="text-gray-400 hover:text-white">FAQ</a></li>
                </ul>
            </div>

            <!-- Employers -->
            <div>
                <h3 class="text-lg font-bold mb-6">For Employers</h3>
                <ul class="space-y-3">
                    <li><a href="<?php echo $baseUrl; ?>/register.php?type=recruiter"
                            class="text-gray-400 hover:text-white">Post Jobs</a></li>
                    <!-- <li><a href="<?php echo $baseUrl; ?>/pricing.php" class="text-gray-400 hover:text-white">Pricing</a></li> -->
                    <!-- <li><a href="<?php echo $baseUrl; ?>/recruitment-solutions.php" class="text-gray-400 hover:text-white">Recruitment Solutions</a></li> -->
                    <li><a href="<?php echo $baseUrl; ?>/employer-faq.php"
                            class="text-gray-400 hover:text-white">Employer FAQ</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/contact.php" class="text-gray-400 hover:text-white">Contact
                            Sales</a></li>
                </ul>
            </div>
        </div>

        <!-- App Download and Newsletter -->
        <div class="mt-12 pt-12 border-t border-gray-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="mb-8 md:mb-0 md:w-1/2">
                    <h3 class="text-xl font-bold mb-4">Get Our Mobile App</h3>
                    <p class="text-gray-400 mb-4">Download our mobile app to search and apply for jobs on the go!</p>
                    <a href="https://play.google.com/store/apps/details?id=com.aptitsolutions.airigo" target="_blank"
                        class="inline-block">
                        <img src="<?php echo $baseUrl; ?>/assets/images/Playstore QR.png" alt="Download Airigojobs App"
                            class="w-36 h-36 object-contain">
                    </a>
                </div>
                <div class="md:w-1/2">
                    <h3 class="text-xl font-bold mb-4">Subscribe to our Newsletter</h3>
                    <p class="text-gray-400">Get the latest job alerts and career tips</p>
                    <div class="flex mt-4">
                        <input type="email" placeholder="Your email address"
                            class="px-6 py-3 bg-gray-800 text-white   focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-80">
                        <button class="bg-blue-600 text-white px-6 py-3   hover:bg-blue-700 font-medium">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-12 pt-8 border-t border-gray-800 text-center text-gray-400">
            <p>&copy; <?php echo date('Y'); ?> Airigojobs. All rights reserved.</p>
            <p class="mt-2 text-sm">Designed with ❤️ for the airline and hospitality industry</p>
        </div>
    </div>
</footer>

<!-- JavaScript -->
<script src="<?php echo $baseUrl; ?>/assets/js/main.js"></script>
<script>
    // Mobile menu toggle
    document.getElementById('mobileMenuButton').addEventListener('click', function () {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function (event) {
        const menuButton = document.getElementById('mobileMenuButton');
        const menu = document.getElementById('mobileMenu');

        if (!menuButton.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    // User dropdown functionality
    document.addEventListener('click', function (event) {
        if (!event.target.closest('.group')) {
            document.querySelectorAll('.group .hidden').forEach(el => {
                el.classList.add('hidden');
            });
        }
    });
</script>
</body>

</html>