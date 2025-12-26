<?php
$pageTitle = "Pricing Plans";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto">
        <section class="container mx-auto px-4">
            <div class="bg-white shadow-md p-6 my-8 justify-start items-start">
                <h1 class="text-2xl md:text-3xl font-bold mb-4">Simple, Transparent Pricing</h1>
                <h2 class="text-lg md:text-xl opacity-90">
                    Choose the perfect plan for your hiring needs. All plans include core features with optional add-ons
                    for
                    advanced functionality.
                </h2>
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12  px-8">
            <!-- Basic Plan -->
            <div class="bg-white rounded-tr-lg rounded-bl-lg shadow-lg p-8 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Basic</h2>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-gray-900">$99</span>
                    <span class="text-gray-600">/month</span>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Post up to 3 jobs</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Basic candidate search</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Application management</span>
                    </li>
                    <li class="flex items-center text-gray-400">
                        <i class="fas fa-times mr-3"></i>
                        <span>Advanced analytics</span>
                    </li>
                    <li class="flex items-center text-gray-400">
                        <i class="fas fa-times mr-3"></i>
                        <span>Premium support</span>
                    </li>
                </ul>
                <a href="contact.php"
                    class="block w-full bg-gray-100 text-gray-800 text-center py-3   font-medium hover:bg-gray-200 transition duration-300">
                    Get Started
                </a>
            </div>

            <!-- Professional Plan -->
            <div class="bg-white rounded-bl-lg rounded-tr-lg shadow-lg p-8 border-2 border-blue-500 relative">
                <div class="absolute top-0 right-0 bg-blue-500 text-white px-4 py-1 rounded-bl-lg rounded-tr-lg">
                    Most Popular
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Professional</h2>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-gray-900">$299</span>
                    <span class="text-gray-600">/month</span>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Post up to 15 jobs</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Advanced candidate search</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Application management</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Basic analytics</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Email support</span>
                    </li>
                </ul>
                <a href="contact.php"
                    class="block w-full bg-blue-600 text-white text-center py-3   font-medium hover:bg-blue-700 transition duration-300">
                    Get Started
                </a>
            </div>

            <!-- Enterprise Plan -->
            <div class="bg-white rounded-tr-lg rounded-bl-lg shadow-lg p-8 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Enterprise</h2>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-gray-900">$599</span>
                    <span class="text-gray-600">/month</span>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Unlimited job postings</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Premium candidate search</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Full application management</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Advanced analytics</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>24/7 premium support</span>
                    </li>
                </ul>
                <a href="contact.php"
                    class="block w-full bg-gray-100 text-gray-800 text-center py-3   font-medium hover:bg-gray-200 transition duration-300">
                    Contact Sales
                </a>
            </div>
        </div>

        <div class="bg-white shadow-lg p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Additional Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="border border-gray-200   p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Featured Jobs</h3>
                    <p class="text-gray-600 mb-4">Boost visibility for your job postings</p>
                    <p class="text-2xl font-bold text-blue-600">$29/job</p>
                </div>

                <div class="border border-gray-200   p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Resume Database Access</h3>
                    <p class="text-gray-600 mb-4">Search our database of qualified candidates</p>
                    <p class="text-2xl font-bold text-blue-600">$199/month</p>
                </div>

                <div class="border border-gray-200   p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Recruiter Support</h3>
                    <p class="text-gray-600 mb-4">Dedicated recruitment assistance</p>
                    <p class="text-2xl font-bold text-blue-600">$499/month</p>
                </div>

                <div class="border border-gray-200   p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Background Checks</h3>
                    <p class="text-gray-600 mb-4">Verify candidate credentials</p>
                    <p class="text-2xl font-bold text-blue-600">$25/check</p>
                </div>

                <div class="border border-gray-200   p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Skills Assessments</h3>
                    <p class="text-gray-600 mb-4">Evaluate candidate skills</p>
                    <p class="text-2xl font-bold text-blue-600">$15/assessment</p>
                </div>

                <div class="border border-gray-200   p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Custom Integrations</h3>
                    <p class="text-gray-600 mb-4">Connect with your existing systems</p>
                    <p class="text-2xl font-bold text-blue-600">Contact us</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-50   p-8 text-center">
            <h2 class="text-2xl font-bold text-blue-800 mb-4">Have Questions About Our Pricing?</h2>
            <p class="text-blue-700 mb-6 max-w-2xl mx-auto">
                Our sales team is ready to help you choose the right plan and answer any questions about our services.
            </p>
            <a href="contact.php"
                class="inline-block bg-blue-600 text-white px-8 py-4   font-medium hover:bg-blue-700 transition duration-300">
                Contact Sales
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>