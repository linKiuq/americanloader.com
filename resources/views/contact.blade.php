<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>Contact Us - Typhon Machinery</title>
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
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 58%, #fffbeb 100%);
        }
        .btn-primary {
            background: linear-gradient(135deg, #facc15 0%, #facc15 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
            box-shadow: 0 0 20px rgba(250, 204, 21, 0.4);
            transform: scale(1.05);
        }
        .footer-accent {
            border-top: 2px solid rgba(250, 204, 21, 0.3);
        }
        .yellow-accent {
            color: #facc15;
        }
        .form-input {
            background-color: #ffffff;
            border: 1px solid rgba(226, 232, 240, 1);
            color: #111827;
            transition: all 0.3s ease;
        }
        .form-input:focus {
            outline: none;
            border-color: rgba(250, 204, 21, 0.7);
            box-shadow: 0 0 15px rgba(250, 204, 21, 0.2);
        }
        .contact-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 1);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('partials.header')

    <!-- Page Header -->
    <section class="hero-bg py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl sm:text-5xl font-black text-gray-950 mb-4">Contact Us</h1>
            <p class="text-lg text-gray-600 max-w-2xl">Get in touch with our team. We're here to answer your questions and help you find the right equipment solution.</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-gray-50 flex-grow">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl p-8 border border-yellow-500 border-opacity-30">
                        <h2 class="text-3xl font-bold text-gray-950 mb-2">Send us a Message</h2>
                        <p class="text-gray-600 mb-8">Fill out the form below and we'll get back to you within 24 hours.</p>

                        @if (session('success'))
                            <div class="mb-7 rounded-lg border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                            @csrf
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-950 mb-2">
                                    <i class="fas fa-user text-yellow-400 mr-2"></i>Full Name
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="John Doe"
                                    class="form-input w-full px-4 py-3 rounded-lg {{ $errors->has('name') ? 'border-red-400' : '' }}"
                                    required
                                >
                                @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-950 mb-2">
                                    <i class="fas fa-envelope text-yellow-400 mr-2"></i>Email Address
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="john@example.com"
                                    class="form-input w-full px-4 py-3 rounded-lg {{ $errors->has('email') ? 'border-red-400' : '' }}"
                                    required
                                >
                                @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Subject Field -->
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-gray-950 mb-2">
                                    <i class="fas fa-heading text-yellow-400 mr-2"></i>Subject
                                </label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    value="{{ old('subject') }}"
                                    placeholder="Equipment Inquiry"
                                    class="form-input w-full px-4 py-3 rounded-lg {{ $errors->has('subject') ? 'border-red-400' : '' }}"
                                    required
                                >
                                @error('subject')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Message Field -->
                            <div>
                                <label for="message" class="block text-sm font-semibold text-gray-950 mb-2">
                                    <i class="fas fa-message text-yellow-400 mr-2"></i>Message
                                </label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="6"
                                    placeholder="Tell us about your project and equipment needs..."
                                    class="form-input w-full px-4 py-3 rounded-lg resize-none {{ $errors->has('message') ? 'border-red-400' : '' }}"
                                    required
                                >{{ old('message') }}</textarea>
                                @error('message')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-primary text-white w-full px-6 py-3 rounded-lg font-bold text-lg flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="space-y-6">
                    <!-- Direct Contact -->
                    <div class="contact-card rounded-xl p-8">
                        <h3 class="text-2xl font-bold text-gray-950 mb-6">Direct Contact</h3>

                        <div class="space-y-6">
                            <!-- Email -->
                            <div>
                                <h4 class="text-yellow-400 font-semibold mb-2 flex items-center">
                                    <i class="fas fa-envelope text-2xl mr-3"></i>Email
                                </h4>
                                <a href="mailto:digital@typhonmachinery.com" class="text-gray-600 hover:text-yellow-400 transition text-sm break-all">
                                    digital@typhonmachinery.com
                                </a>
                            </div>

                            <!-- Phone -->
                            <div>
                                <h4 class="text-yellow-400 font-semibold mb-2 flex items-center">
                                    <i class="fas fa-phone text-2xl mr-3"></i>Phone
                                </h4>
                                <a href="tel:+15551234567" class="text-gray-600 hover:text-yellow-400 transition text-sm">
                                    +1 (555) 123-4567
                                </a>
                            </div>

                            <!-- Address -->
                            <div>
                                <h4 class="text-yellow-400 font-semibold mb-2 flex items-center">
                                    <i class="fas fa-map-marker-alt text-2xl mr-3"></i>Address
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Typhon Machinery<br>
                                    Commerce, CA 90040<br>
                                    United States
                                </p>
                            </div>

                            <!-- Hours -->
                            <div>
                                <h4 class="text-yellow-400 font-semibold mb-2 flex items-center">
                                    <i class="fas fa-clock text-2xl mr-3"></i>Business Hours
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Monday - Friday: 8:00 AM - 6:00 PM PST<br>
                                    Saturday: 9:00 AM - 2:00 PM PST<br>
                                    Sunday: Closed<br>
                                    <span class="text-yellow-400 font-semibold">24/7 Emergency Support</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="contact-card rounded-xl p-8">
                        <h3 class="text-xl font-bold text-gray-950 mb-4 flex items-center">
                            <i class="fas fa-headset text-yellow-500 mr-3"></i>Response Time
                        </h3>
                        <p class="text-gray-600 text-sm">
                            We aim to respond to all inquiries within 24 hours during business hours. For urgent matters, please call our direct line.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Placeholder Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-950 mb-8 text-center">Find Us</h2>
            <div class="bg-gradient-to-br from-white to-white rounded-xl overflow-hidden border border-yellow-500 border-opacity-30" style="height: 400px;">
                <!-- Embedded Map Placeholder -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3307.4629869752544!2d-118.1604!3d33.9817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c355555555%3A0x555555555555!2sCommerce%2C%20CA!5e0!3m2!1sen!2sus!4v1234567890"
                    width="100%"
                    height="100%"
                    style="border:none;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
            <div class="mt-8 text-center">
                <p class="text-gray-600 mb-4">
                    <i class="fas fa-map-marker-alt text-yellow-400 mr-2"></i>
                    Commerce, CA 90040
                </p>
                <button class="btn-primary text-white px-8 py-3 rounded-lg font-semibold">
                    <i class="fas fa-directions mr-2"></i>Get Directions
                </button>
            </div>
        </div>
    </section>

    @include('partials.footer')
</body>
</html>
