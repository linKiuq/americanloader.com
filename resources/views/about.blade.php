<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About - Product Machinery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #ffffff;
            color: #111827;
        }
        .sticky-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.35);
        }
        .hero-bg {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 58%, #eef6ff 100%);
        }
        .value-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 1);
            transition: all 0.3s ease;
        }
        .value-card:hover {
            border-color: rgba(59, 130, 246, 0.7);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
            transform: translateY(-5px);
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
            transform: scale(1.05);
        }
        .footer-accent {
            border-top: 2px solid rgba(59, 130, 246, 0.3);
        }
        .blue-accent {
            color: #3b82f6;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('partials.header')

    <!-- Page Header -->
    <section class="hero-bg py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl sm:text-5xl font-black text-gray-950 mb-4">About Typhon Machinery</h1>
            <p class="text-lg text-gray-600 max-w-2xl">Leading the industry in heavy machinery innovation, reliability, and customer excellence since 2010.</p>
        </div>
    </section>

    <!-- History Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <h2 class="text-4xl font-bold text-gray-950 mb-6">Our Story</h2>
                    <p class="text-gray-600 text-lg mb-4">
                        Founded in 2010, Typhon Machinery emerged from a vision to revolutionize heavy equipment manufacturing. Our founders, a collective of engineers with decades of combined experience, recognized a gap in the market for truly reliable, innovative machinery.
                    </p>
                    <p class="text-gray-600 text-lg mb-4">
                        What started as a small workshop in Commerce, California has evolved into an industry-leading manufacturer trusted by construction firms, mining operations, and industrial enterprises worldwide.
                    </p>
                    <p class="text-gray-600 text-lg">
                        Today, we continue our commitment to engineering excellence, pushing the boundaries of what's possible in heavy machinery technology while maintaining the highest standards of quality and customer service.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-white to-white rounded-xl p-8 border border-blue-500 border-opacity-30">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <h3 class="text-4xl font-bold text-blue-400 mb-2">14+</h3>
                            <p class="text-gray-600">Years of Excellence</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-4xl font-bold text-blue-400 mb-2">2000+</h3>
                            <p class="text-gray-600">Units Deployed</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-4xl font-bold text-blue-400 mb-2">50+</h3>
                            <p class="text-gray-600">Countries Served</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-4xl font-bold text-blue-400 mb-2">98%</h3>
                            <p class="text-gray-600">Customer Satisfaction</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Grid -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-950 mb-4">Our Core Values</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">The principles that guide every decision and drive our commitment to excellence.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Reliability -->
                <div class="value-card p-8 rounded-xl cursor-pointer group">
                    <div class="w-16 h-16 bg-blue-500 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-shield-check text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-950 mb-3">Reliability</h3>
                    <p class="text-gray-600">Our machinery is engineered for absolute dependability. Every component undergoes rigorous testing to ensure performance in the most demanding conditions.</p>
                </div>

                <!-- Power -->
                <div class="value-card p-8 rounded-xl cursor-pointer group">
                    <div class="w-16 h-16 bg-blue-500 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-bolt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-950 mb-3">Power</h3>
                    <p class="text-gray-600">Deliver exceptional performance with industry-leading horsepower, torque, and lifting capacity that outperforms the competition.</p>
                </div>

                <!-- Support -->
                <div class="value-card p-8 rounded-xl cursor-pointer group">
                    <div class="w-16 h-16 bg-blue-500 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-hands-helping text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-950 mb-3">Support</h3>
                    <p class="text-gray-600">Our commitment extends beyond the sale. Dedicated technical support, maintenance services, and spare parts availability 24/7.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Facility Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-gray-950 mb-16 text-center">Our Primary Facility</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="bg-gradient-to-br from-white to-white rounded-xl p-8 border border-blue-500 border-opacity-30">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-950 mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-3 text-3xl"></i>
                            Commerce, California
                        </h3>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="text-blue-400 font-semibold mb-2 flex items-center">
                                <i class="fas fa-building mr-2"></i>Facility Size
                            </h4>
                            <p class="text-gray-600">65,000 sq ft state-of-the-art manufacturing and assembly facility</p>
                        </div>

                        <div>
                            <h4 class="text-blue-400 font-semibold mb-2 flex items-center">
                                <i class="fas fa-tools mr-2"></i>Advanced Equipment
                            </h4>
                            <p class="text-gray-600">CNC machining centers, hydraulic testing labs, and precision welding stations</p>
                        </div>

                        <div>
                            <h4 class="text-blue-400 font-semibold mb-2 flex items-center">
                                <i class="fas fa-users mr-2"></i>Skilled Team
                            </h4>
                            <p class="text-gray-600">150+ dedicated engineers, technicians, and quality assurance specialists</p>
                        </div>

                        <div>
                            <h4 class="text-blue-400 font-semibold mb-2 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>Certifications
                            </h4>
                            <p class="text-gray-600">ISO 9001:2015, OSHA certified, and meets all EPA environmental standards</p>
                        </div>

                        <div>
                            <h4 class="text-blue-400 font-semibold mb-2 flex items-center">
                                <i class="fas fa-clock mr-2"></i>Production Capacity
                            </h4>
                            <p class="text-gray-600">250+ units annually with custom configuration options</p>
                        </div>
                    </div>

                    <button class="btn-primary text-white px-6 py-3 rounded-lg font-semibold w-full mt-8">
                        <i class="fas fa-map-location-dot mr-2"></i>Visit Our Facility
                    </button>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-lg border border-blue-500 border-opacity-20">
                        <h4 class="text-xl font-bold text-gray-950 mb-3 flex items-center">
                            <i class="fas fa-industry text-blue-500 mr-2 text-2xl"></i>
                            Manufacturing Excellence
                        </h4>
                        <p class="text-gray-600">Our facility combines traditional craftsmanship with cutting-edge automation, ensuring every machine meets our exacting standards.</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg border border-blue-500 border-opacity-20">
                        <h4 class="text-xl font-bold text-gray-950 mb-3 flex items-center">
                            <i class="fas fa-leaf text-blue-500 mr-2 text-2xl"></i>
                            Sustainability
                        </h4>
                        <p class="text-gray-600">Committed to environmental responsibility with modern emissions control and recycling programs.</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg border border-blue-500 border-opacity-20">
                        <h4 class="text-xl font-bold text-gray-950 mb-3 flex items-center">
                            <i class="fas fa-graduation-cap text-blue-500 mr-2 text-2xl"></i>
                            Training Center
                        </h4>
                        <p class="text-gray-600">On-site training facility for operator certification and maintenance programs.</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg border border-blue-500 border-opacity-20">
                        <h4 class="text-xl font-bold text-gray-950 mb-3 flex items-center">
                            <i class="fas fa-truck mr-2 text-blue-500 text-2xl"></i>
                            Logistics Hub
                        </h4>
                        <p class="text-gray-600">Strategically located for efficient delivery across North America and international shipping.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
</body>
</html>
