<?php
$pageTitle = "Contact Us";
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Contact Us</h1>
                <p class="text-xl opacity-90 max-w-2xl mx-auto">
                    Get in touch with our team. We're here to help you with any questions about Airigojobs.
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Contact Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Get in Touch</h2>
                    
                    <div class="space-y-8">
                        <!-- Contact Info -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Contact Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">Headquarters</p>
                                        <p class="text-gray-600">123 Aviation Avenue<br>Suite 500<br>New York, NY 10001</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                        <i class="fas fa-phone text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">Phone Number</p>
                                        <p class="text-gray-600">+1 (555) 123-4567</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                        <i class="fas fa-envelope text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">Email Address</p>
                                        <p class="text-gray-600">support@airigojobs.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Office Hours -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Office Hours</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Monday - Friday</span>
                                    <span class="font-medium text-gray-800">9:00 AM - 6:00 PM</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Saturday</span>
                                    <span class="font-medium text-gray-800">10:00 AM - 4:00 PM</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Sunday</span>
                                    <span class="font-medium text-gray-800">Closed</span>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Support -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="bg-blue-600 p-2 rounded-lg mr-3">
                                    <i class="fas fa-headset text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-blue-800 mb-2">24/7 Emergency Support</h4>
                                    <p class="text-blue-700 text-sm">For urgent technical issues affecting job applications or hiring processes</p>
                                    <p class="text-blue-600 font-medium mt-2">+1 (555) 987-6543</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="mt-8 bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Quick Links</h3>
                    <div class="space-y-3">
                        <a href="faq.php" class="flex items-center text-gray-700 hover:text-blue-600">
                            <i class="fas fa-question-circle mr-3"></i>
                            <span>Frequently Asked Questions</span>
                        </a>
                        <a href="support.php" class="flex items-center text-gray-700 hover:text-blue-600">
                            <i class="fas fa-life-ring mr-3"></i>
                            <span>Help Center & Support</span>
                        </a>
                        <a href="privacy.php" class="flex items-center text-gray-700 hover:text-blue-600">
                            <i class="fas fa-shield-alt mr-3"></i>
                            <span>Privacy Policy</span>
                        </a>
                        <a href="terms.php" class="flex items-center text-gray-700 hover:text-blue-600">
                            <i class="fas fa-file-contract mr-3"></i>
                            <span>Terms of Service</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Send us a Message</h2>
                    <p class="text-gray-600 mb-8">Fill out the form below and we'll get back to you as soon as possible.</p>
                    
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    First Name *
                                </label>
                                <input type="text" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Last Name *
                                </label>
                                <input type="text" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address *
                                </label>
                                <input type="email" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number
                                </label>
                                <input type="tel" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Subject *
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="technical">Technical Support</option>
                                <option value="billing">Billing & Payments</option>
                                <option value="employer">Employer Services</option>
                                <option value="jobseeker">Job Seeker Support</option>
                                <option value="feedback">Feedback & Suggestions</option>
                                <option value="partnership">Partnership Opportunities</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Message *
                            </label>
                            <textarea rows="6" 
                                      required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Please describe your inquiry in detail..."></textarea>
                        </div>
                        
                        <div>
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       required
                                       class="mt-1 mr-3 h-4 w-4 text-blue-600 rounded">
                                <span class="text-gray-700">
                                    I agree to the <a href="privacy.php" class="text-blue-600 hover:text-blue-800">Privacy Policy</a> and consent to Airigojobs contacting me regarding my inquiry.
                                </span>
                            </label>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-700 transition duration-300">
                                <i class="fas fa-paper-plane mr-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>

                <!-- FAQ Section -->
                <div class="mt-8 bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
                    
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <button class="flex items-center justify-between w-full text-left">
                                <span class="font-medium text-gray-800">How long does it take to get a response?</span>
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </button>
                            <div class="mt-2 text-gray-600 hidden">
                                We typically respond to all inquiries within 24 hours during business days. For urgent matters, please use our emergency support line.
                            </div>
                        </div>
                        
                        <div class="border-b pb-4">
                            <button class="flex items-center justify-between w-full text-left">
                                <span class="font-medium text-gray-800">Can I schedule a demo for employer services?</span>
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </button>
                            <div class="mt-2 text-gray-600 hidden">
                                Yes! We offer personalized demos for employers. Please select "Employer Services" as your subject and we'll schedule a convenient time for you.
                            </div>
                        </div>
                        
                        <div class="border-b pb-4">
                            <button class="flex items-center justify-between w-full text-left">
                                <span class="font-medium text-gray-800">Do you have international offices?</span>
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </button>
                            <div class="mt-2 text-gray-600 hidden">
                                While our headquarters are in New York, we have regional representatives across major aviation hubs worldwide. Contact us to connect with your local representative.
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="faq.php" class="text-blue-600 hover:text-blue-800 font-medium">
                            View All FAQs <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Map -->
                <div class="mt-8 bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="h-64 bg-blue-100 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-map-marker-alt text-blue-600 text-4xl mb-4"></i>
                            <p class="text-gray-700 font-medium">123 Aviation Avenue, New York, NY 10001</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// FAQ toggle functionality
document.querySelectorAll('.border-b button').forEach(button => {
    button.addEventListener('click', function() {
        const answer = this.nextElementSibling;
        const icon = this.querySelector('i');
        
        if (answer.classList.contains('hidden')) {
            answer.classList.remove('hidden');
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            answer.classList.add('hidden');
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    });
});

// Form submission
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Here you would typically send this to your server
    console.log('Form submitted:', data);
    
    // Show success message
    alert('Thank you for your message! We will get back to you within 24 hours.');
    this.reset();
});
</script>

<?php require_once 'includes/footer.php'; ?>