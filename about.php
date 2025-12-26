<?php
$pageTitle = "About Us";
require_once 'includes/header.php';
?>

<div class="min-h-screen">
    <!-- Hero Section -->
    <!-- <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">About Airigojobs</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto opacity-90">
                Connecting airline and hospitality professionals with their dream careers since 2024
            </p>
        </div>
    </section> -->

    <section class="container mx-auto px-4">
        <div class="bg-white shadow-md p-6 my-8 justify-start items-start">
            <h1 class="text-2xl md:text-3xl font-bold mb-4">About Airigojobs</h1>
            <h2 class="text-lg md:text-xl opacity-90">
                Connecting airline and hospitality professionals with their dream careers since 2024
            </h2>
        </div>
    </section>

    <!-- Our Story -->
    <section class="py-16 lg:py-24 bg-gradient-to-b from-white to-blue-50 overflow-hidden">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                <!-- Text Content -->
                <div class="order-2 lg:order-1 space-y-6 lg:space-y-8">
                    <h2 class="text-3xl lg:text-4xl xl:text-5xl font-bold text-gray-900 leading-tight">
                        Our Story
                    </h2>

                    <div class="space-y-5 text-lg text-gray-700 leading-relaxed">
                        <p>
                            Founded in 2024, Airigojobs was born from a simple observation: the airline and hospitality
                            industries, while being among the largest employers globally, lacked a specialized platform
                            connecting talented professionals with the right opportunities.
                        </p>
                        <p>
                            Our founders, industry veterans with decades of combined experience in aviation and
                            hospitality, recognized
                            the need for a dedicated platform that understands the unique requirements of these sectors.
                            From pilots and flight attendants to hotel managers and customer service professionals, each
                            role demands specific skills and qualifications.
                        </p>
                        <p>
                            Today, Airigojobs has grown to become the leading job portal for airline and hospitality
                            professionals, serving thousands of job seekers and employers across the globe.
                        </p>
                    </div>
                </div>

                <!-- Image Side -->
                <div class="order-1 lg:order-2 relative">
                    <!-- Main Image with hover zoom & subtle effects -->
                    <div class="relative overflow-hidden shadow-2xl group">
                        <img src="https://media.istockphoto.com/id/1068158766/photo/confident-multi-ethnic-group-of-employees-at-a-hotel-reception-all-looking-at-camera-smiling.jpg?s=612x612&w=0&k=20&c=S-90j_6XmzNq6Wkfbm2utpH4ZVKcHWMHNOHmCKUWeDc="
                            alt="Diverse multicultural team of hospitality professionals smiling confidently"
                            class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">

                        <!-- Subtle overlay gradient on hover -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <!-- Shine sweep effect on hover -->
                        <!-- <div
                            class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-linear pointer-events-none">
                            <div
                                class="w-64 h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -rotate-12">
                            </div>
                        </div> -->
                    </div>

                    <!-- Decorative blurred accents -->
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-blue-500/10 blur-3xl"></div>
                    <div class="absolute -top-6 -right-6 w-48 h-48 bg-purple-500/10 blur-3xl"></div>
                </div>

            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission & Vision</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Driving excellence in airline and hospitality recruitment</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto px-4">
                <!-- Mission Card -->
                <div
                    class="group relative bg-white shadow-lg overflow-hidden transition-all duration-500 ease-out hover:shadow-2xl hover:-translate-y-3">
                    <!-- Gradient Overlay (appears on hover) -->
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-out">
                    </div>

                    <!-- Content -->
                    <div class="relative p-8 md:p-10">
                        <!-- Icon Container with animated background -->
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 mb-8 bg-blue-100 transition-all duration-500 group-hover:bg-white/20 group-hover:scale-110">
                            <i
                                class="fas fa-bullseye text-3xl text-blue-600 transition-colors duration-500 group-hover:text-white"></i>
                        </div>

                        <!-- Title -->
                        <h3
                            class="text-2xl md:text-3xl font-bold mb-4 text-gray-900 transition-colors duration-500 group-hover:text-white">
                            Our Mission
                        </h3>

                        <!-- Description -->
                        <p
                            class="text-gray-600 leading-relaxed transition-colors duration-500 group-hover:text-white/90">
                            To revolutionize how airline and hospitality professionals find meaningful careers by
                            providing a specialized platform that understands industry-specific needs, accelerates
                            hiring processes, and fosters long-term career growth.
                        </p>
                    </div>

                    <!-- Subtle shine effect on hover -->
                    <div
                        class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-linear pointer-events-none">
                        <div
                            class="w-64 h-full bg-gradient-to-r from-transparent via-white/10 to-transparent rotate-12">
                        </div>
                    </div>
                </div>

                <!-- Vision Card -->
                <div
                    class="group relative bg-white shadow-lg overflow-hidden transition-all duration-500 ease-out hover:shadow-2xl hover:-translate-y-3">
                    <!-- Gradient Overlay (appears on hover) -->
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-purple-500 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-out">
                    </div>

                    <!-- Content -->
                    <div class="relative p-8 md:p-10">
                        <!-- Icon Container with animated background -->
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 mb-8 bg-purple-100 transition-all duration-500 group-hover:bg-white/20 group-hover:scale-110">
                            <i
                                class="fas fa-eye text-3xl text-purple-600 transition-colors duration-500 group-hover:text-white"></i>
                        </div>

                        <!-- Title -->
                        <h3
                            class="text-2xl md:text-3xl font-bold mb-4 text-gray-900 transition-colors duration-500 group-hover:text-white">
                            Our Vision
                        </h3>

                        <!-- Description -->
                        <p
                            class="text-gray-600 leading-relaxed transition-colors duration-500 group-hover:text-white/90">
                            To become the global standard for airline and hospitality recruitment, recognized for
                            excellence in connecting talent with opportunity while setting new benchmarks for
                            industry-specific job matching and career development.
                        </p>
                    </div>

                    <!-- Subtle shine effect on hover -->
                    <div
                        class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-linear pointer-events-none">
                        <div
                            class="w-64 h-full bg-gradient-to-r from-transparent via-white/10 to-transparent rotate-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 lg:py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-12 lg:mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Our Core Values</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">The principles that guide everything we do</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                <!-- Excellence -->
                <div class="group relative text-center opacity-0 translate-y-8 animate-fade-in-up"
                    style="animation-delay: 100ms;">
                    <div
                        class="relative bg-white   p-8 shadow-lg transition-all duration-500 ease-out hover:shadow-2xl hover:-translate-y-4 overflow-hidden">
                        <!-- Gradient Background -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600   opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <!-- Dark overlay for better text readability on hover -->
                        <div
                            class="absolute inset-0 bg-black/30   opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <!-- Icon -->
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 mx-auto mb-8 bg-blue-100   transition-all duration-500 group-hover:bg-white/20 group-hover:scale-110">
                            <i
                                class="fas fa-shield-alt text-4xl text-blue-600 transition-colors duration-500 group-hover:text-white"></i>
                        </div>

                        <!-- Title -->
                        <h3
                            class="text-xl lg:text-2xl font-bold mb-4 text-gray-900 transition-colors duration-500 group-hover:text-white relative z-10">
                            Excellence
                        </h3>

                        <!-- Description - Now fully visible on hover -->
                        <p
                            class="text-gray-600 leading-relaxed transition-all duration-500 group-hover:text-white relative z-10">
                            We strive for excellence in every aspect of our service, from platform technology to
                            customer support.
                        </p>

                        <!-- Shine effect -->
                        <!-- <div
                            class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-linear pointer-events-none">
                            <div
                                class="w-64 h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -rotate-12">
                            </div>
                        </div> -->
                    </div>
                </div>

                <!-- Integrity -->
                <div class="group relative text-center opacity-0 translate-y-8 animate-fade-in-up"
                    style="animation-delay: 200ms;">
                    <div
                        class="relative bg-white   p-8 shadow-lg transition-all duration-500 ease-out hover:shadow-2xl hover:-translate-y-4 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-teal-500 to-teal-600   opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute inset-0 bg-black/30   opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <div
                            class="inline-flex items-center justify-center w-20 h-20 mx-auto mb-8 bg-teal-100   transition-all duration-500 group-hover:bg-white/20 group-hover:scale-110">
                            <i
                                class="fas fa-handshake text-4xl text-teal-600 transition-colors duration-500 group-hover:text-white"></i>
                        </div>

                        <h3
                            class="text-xl lg:text-2xl font-bold mb-4 text-gray-900 transition-colors duration-500 group-hover:text-white relative z-10">
                            Integrity
                        </h3>

                        <p
                            class="text-gray-600 leading-relaxed transition-all duration-500 group-hover:text-white relative z-10">
                            We operate with transparency, honesty, and ethical practices in all our interactions.
                        </p>

                        <!-- <div
                            class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-linear pointer-events-none">
                            <div
                                class="w-64 h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -rotate-12">
                            </div>
                        </div> -->
                    </div>
                </div>

                <!-- Collaboration -->
                <div class="group relative text-center opacity-0 translate-y-8 animate-fade-in-up"
                    style="animation-delay: 300ms;">
                    <div
                        class="relative bg-white   p-8 shadow-lg transition-all duration-500 ease-out hover:shadow-2xl hover:-translate-y-4 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-purple-500 to-purple-600   opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute inset-0 bg-black/30   opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <div
                            class="inline-flex items-center justify-center w-20 h-20 mx-auto mb-8 bg-purple-100   transition-all duration-500 group-hover:bg-white/20 group-hover:scale-110">
                            <i
                                class="fas fa-users text-4xl text-purple-600 transition-colors duration-500 group-hover:text-white"></i>
                        </div>

                        <h3
                            class="text-xl lg:text-2xl font-bold mb-4 text-gray-900 transition-colors duration-500 group-hover:text-white relative z-10">
                            Collaboration
                        </h3>

                        <p
                            class="text-gray-600 leading-relaxed transition-all duration-500 group-hover:text-white relative z-10">
                            We believe in the power of partnership between job seekers, employers, and our team.
                        </p>

                        <!-- <div
                            class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-linear pointer-events-none">
                            <div
                                class="w-64 h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -rotate-12">
                            </div>
                        </div> -->
                    </div>
                </div>

                <!-- Innovation -->
                <div class="group relative text-center opacity-0 translate-y-8 animate-fade-in-up"
                    style="animation-delay: 400ms;">
                    <div
                        class="relative bg-white   p-8 shadow-lg transition-all duration-500 ease-out hover:shadow-2xl hover:-translate-y-4 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-500   opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute inset-0 bg-black/30   opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <div
                            class="inline-flex items-center justify-center w-20 h-20 mx-auto mb-8 bg-orange-100   transition-all duration-500 group-hover:bg-white/20 group-hover:scale-110">
                            <i
                                class="fas fa-rocket text-4xl text-orange-600 transition-colors duration-500 group-hover:text-white"></i>
                        </div>

                        <h3
                            class="text-xl lg:text-2xl font-bold mb-4 text-gray-900 transition-colors duration-500 group-hover:text-white relative z-10">
                            Innovation
                        </h3>

                        <p
                            class="text-gray-600 leading-relaxed transition-all duration-500 group-hover:text-white relative z-10">
                            We continuously innovate to improve our platform and services for the evolving needs of our
                            industry.
                        </p>

                        <!-- <div
                            class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-linear pointer-events-none">
                            <div
                                class="w-64 h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -rotate-12">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(32px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }
    </style>

    <!-- Team -->
    <section class="py-16 lg:py-24 bg-gray-50 overflow-hidden">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-12 lg:mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Meet Our Leadership Team</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Experienced professionals dedicated to transforming airline and hospitality recruitment
                </p>
            </div>

            <!-- Desktop Grid (3 cards) -->
            <div class="hidden md:grid md:grid-cols-3 gap-8 lg:gap-12">
                <div
                    class="group relative bg-white   shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-4">
                    <div
                        class="absolute inset-0 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div
                        class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500  ">
                    </div>

                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face"
                        alt="John Carter"
                        class="w-40 h-40 mx-auto mt-8 object-cover rounded-full border-4 border-white shadow-md transition-all duration-500 group-hover:scale-110 group-hover:border-white/30">

                    <div class="relative z-10 p-8 pt-6">
                        <h3
                            class="text-xl lg:text-2xl font-bold mb-2 text-gray-900 transition-colors duration-500 group-hover:text-white">
                            John Carter
                        </h3>
                        <p
                            class="text-blue-600 font-semibold mb-4 transition-colors duration-500 group-hover:text-white">
                            CEO & Founder
                        </p>
                        <p class="text-gray-600 leading-relaxed transition-colors duration-500 group-hover:text-white">
                            Former airline executive with 20+ years of experience in airline management and recruitment.
                        </p>
                    </div>

                    <!-- <div
                        class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-linear pointer-events-none">
                        <div
                            class="w-64 h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -rotate-12">
                        </div>
                    </div> -->
                </div>

                <div
                    class="group relative bg-white   shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-4">
                    <div
                        class="absolute inset-0 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div
                        class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500  ">
                    </div>

                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b612b786?w=400&h=400&fit=crop&crop=face"
                        alt="Sarah Johnson"
                        class="w-40 h-40 mx-auto mt-8 object-cover rounded-full border-4 border-white shadow-md transition-all duration-500 group-hover:scale-110 group-hover:border-white/30">

                    <div class="relative z-10 p-8 pt-6">
                        <h3
                            class="text-xl lg:text-2xl font-bold mb-2 text-gray-900 transition-colors duration-500 group-hover:text-white">
                            Sarah Johnson
                        </h3>
                        <p
                            class="text-blue-600 font-semibold mb-4 transition-colors duration-500 group-hover:text-white">
                            Chief Technology Officer
                        </p>
                        <p class="text-gray-600 leading-relaxed transition-colors duration-500 group-hover:text-white">
                            Technology innovator specializing in AI-driven recruitment solutions and platform
                            development.
                        </p>
                    </div>

                    <!-- <div
                        class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-linear pointer-events-none">
                        <div
                            class="w-64 h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -rotate-12">
                        </div>
                    </div> -->
                </div>

                <div
                    class="group relative bg-white   shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-4">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div
                        class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500  ">
                    </div>

                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop&crop=face"
                        alt="Michael Rodriguez"
                        class="w-40 h-40 mx-auto mt-8 object-cover rounded-full border-4 border-white shadow-md transition-all duration-500 group-hover:scale-110 group-hover:border-white/30">

                    <div class="relative z-10 p-8 pt-6">
                        <h3
                            class="text-xl lg:text-2xl font-bold mb-2 text-gray-900 transition-colors duration-500 group-hover:text-white">
                            Michael Rodriguez
                        </h3>
                        <p
                            class="text-blue-600 font-semibold mb-4 transition-colors duration-500 group-hover:text-white">
                            Head of Hospitality Relations
                        </p>
                        <p class="text-gray-600 leading-relaxed transition-colors duration-500 group-hover:text-white">
                            Hospitality industry veteran with extensive experience in hotel management and staffing.
                        </p>
                    </div>

                    <!-- <div
                        class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-linear pointer-events-none">
                        <div
                            class="w-64 h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -rotate-12">
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Mobile Auto-Scrolling Carousel -->
            <div class="md:hidden relative">
                <div class="flex overflow-x-auto snap-x snap-mandatory scrollbar-hide gap-6 px-4 py-8 -mx-4">
                    <!-- Duplicate cards for seamless loop -->
                    <div class="flex-none w-80 snap-center">
                        <!-- John Carter -->
                        <div
                            class="group relative bg-white   shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500  ">
                            </div>

                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face"
                                alt="John Carter"
                                class="w-32 h-32 mx-auto mt-6 object-cover rounded-full border-4 border-white shadow-md">

                            <div class="relative z-10 p-6 pt-4">
                                <h3
                                    class="text-xl font-bold mb-2 text-gray-900 group-hover:text-white transition-colors">
                                    John Carter</h3>
                                <p class="text-blue-600 font-semibold mb-3 group-hover:text-white transition-colors">CEO
                                    & Founder</p>
                                <p class="text-gray-600 group-hover:text-white transition-colors text-sm">
                                    Former airline executive with 20+ years of experience in airline management and
                                    recruitment.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-none w-80 snap-center">
                        <!-- Sarah Johnson -->
                        <div
                            class="group relative bg-white   shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-purple-500 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500  ">
                            </div>

                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b612b786?w=400&h=400&fit=crop&crop=face"
                                alt="Sarah Johnson"
                                class="w-32 h-32 mx-auto mt-6 object-cover rounded-full border-4 border-white shadow-md">

                            <div class="relative z-10 p-6 pt-4">
                                <h3
                                    class="text-xl font-bold mb-2 text-gray-900 group-hover:text-white transition-colors">
                                    Sarah Johnson</h3>
                                <p class="text-blue-600 font-semibold mb-3 group-hover:text-white transition-colors">
                                    Chief Technology Officer</p>
                                <p class="text-gray-600 group-hover:text-white transition-colors text-sm">
                                    Technology innovator specializing in AI-driven recruitment solutions and platform
                                    development.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-none w-80 snap-center">
                        <!-- Michael Rodriguez -->
                        <div
                            class="group relative bg-white   shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-teal-500 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500  ">
                            </div>

                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop&crop=face"
                                alt="Michael Rodriguez"
                                class="w-32 h-32 mx-auto mt-6 object-cover rounded-full border-4 border-white shadow-md">

                            <div class="relative z-10 p-6 pt-4">
                                <h3
                                    class="text-xl font-bold mb-2 text-gray-900 group-hover:text-white transition-colors">
                                    Michael Rodriguez</h3>
                                <p class="text-blue-600 font-semibold mb-3 group-hover:text-white transition-colors">
                                    Head of Hospitality Relations</p>
                                <p class="text-gray-600 group-hover:text-white transition-colors text-sm">
                                    Hospitality industry veteran with extensive experience in hotel management and
                                    staffing.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Hide scrollbar but keep functionality */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Optional: Auto-scroll animation for mobile (uncomment to enable true auto-scroll) */
        /*
    @keyframes scrollMobile {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-100% + 320px)); } /* Adjust based on card width */
        }

        .md:hidden .flex {
            animation: scrollMobile 20s linear infinite;
        }

        .md:hidden .flex:hover {
            animation-play-state: paused;
        }

        */
    </style>

    <!-- CTA -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Join Our Mission</h2>
            <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
                Whether you're looking for your dream job in airline or hospitality, or seeking talented professionals
                for your organization, Airigojobs is here to help.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="register.php?type=jobseeker"
                    class="bg-blue-600 text-white px-8 py-4   font-bold text-lg hover:bg-blue-700 transition duration-300">
                    Start Your Job Search
                </a>
                <a href="register.php?type=recruiter"
                    class="bg-white border-2 border-blue-600 text-blue-600 px-8 py-4   font-bold text-lg hover:bg-blue-50 transition duration-300">
                    Post Jobs Free
                </a>
            </div>
        </div>
    </section>
</div>

<?php require_once 'includes/footer.php'; ?>