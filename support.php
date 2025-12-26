<?php
$pageTitle = "Support Center";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white shadow-lg   overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-8 px-6">
                <h1 class="text-3xl font-bold">Support Center</h1>
                <p class="text-blue-100 mt-2">Get help with your Airigojobs account and services</p>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <div class="text-center p-6 border   hover:shadow-md transition duration-300">
                        <div class="w-16 h-16 bg-blue-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-question-circle text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">FAQ</h3>
                        <p class="text-gray-600 mb-4">Find answers to common questions</p>
                        <a href="faq.php" class="text-blue-600 font-medium hover:underline">View FAQ</a>
                    </div>
                    
                    <div class="text-center p-6 border   hover:shadow-md transition duration-300">
                        <div class="w-16 h-16 bg-green-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-life-ring text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Help Center</h3>
                        <p class="text-gray-600 mb-4">Step-by-step guides and tutorials</p>
                        <a href="#" class="text-blue-600 font-medium hover:underline">Browse Guides</a>
                    </div>
                    
                    <div class="text-center p-6 border   hover:shadow-md transition duration-300">
                        <div class="w-16 h-16 bg-purple-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-headset text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Contact Us</h3>
                        <p class="text-gray-600 mb-4">Get in touch with our support team</p>
                        <a href="contact.php" class="text-blue-600 font-medium hover:underline">Contact Support</a>
                    </div>
                </div>
                
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Popular Topics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="#" class="flex items-center p-4 border   hover:bg-gray-50 transition duration-300">
                            <i class="fas fa-user-circle text-blue-600 text-xl mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800">Account Management</h3>
                                <p class="text-gray-600 text-sm">How to create, update, or delete your account</p>
                            </div>
                        </a>
                        
                        <a href="#" class="flex items-center p-4 border   hover:bg-gray-50 transition duration-300">
                            <i class="fas fa-briefcase text-blue-600 text-xl mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800">Job Applications</h3>
                                <p class="text-gray-600 text-sm">Managing your applications and profile</p>
                            </div>
                        </a>
                        
                        <a href="#" class="flex items-center p-4 border   hover:bg-gray-50 transition duration-300">
                            <i class="fas fa-building text-blue-600 text-xl mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800">Posting Jobs</h3>
                                <p class="text-gray-600 text-sm">How to post and manage job listings</p>
                            </div>
                        </a>
                        
                        <a href="#" class="flex items-center p-4 border   hover:bg-gray-50 transition duration-300">
                            <i class="fas fa-search text-blue-600 text-xl mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800">Job Search</h3>
                                <p class="text-gray-600 text-sm">Searching for jobs and using filters</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="bg-blue-50 border border-blue-200   p-6 mb-12">
                    <h2 class="text-xl font-bold text-blue-800 mb-4">Need Immediate Help?</h2>
                    <p class="text-blue-700 mb-4">
                        Our support team is available 24/7 for urgent issues. Contact us using the information below.
                    </p>
                    <div class="flex flex-wrap gap-6">
                        <div>
                            <h3 class="font-semibold text-blue-800 mb-2">Email Support</h3>
                            <p class="text-blue-700">support@airigojobs.com</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-blue-800 mb-2">Phone Support</h3>
                            <p class="text-blue-700">+1 (555) 123-4567</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-blue-800 mb-2">Emergency Line</h3>
                            <p class="text-blue-700">+1 (555) 987-6543</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Submit a Support Request</h2>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">First Name</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Last Name</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email Address</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Subject</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Issue Category</label>
                            <select class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>Select a category</option>
                                <option>Account Issue</option>
                                <option>Job Application</option>
                                <option>Job Posting</option>
                                <option>Billing</option>
                                <option>Technical Issue</option>
                                <option>Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Describe your issue</label>
                            <textarea rows="5" class="w-full px-4 py-3 border border-gray-300   focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-8 py-3   font-medium hover:bg-blue-700 transition duration-300">
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>