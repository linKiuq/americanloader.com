<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>Contact Us - The Power Loader</title>
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
            <p class="text-lg text-gray-600 max-w-2xl">Send equipment, attachment, compatibility, sales, and technical-support questions through the form below.</p>
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
                        <p class="text-gray-600 mb-8">Fill out the form below and the team will respond by email.</p>

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
                                <a href="mailto:sales@typhonmachinery.com" class="text-gray-600 hover:text-yellow-400 transition text-sm break-all">
                                    sales@typhonmachinery.com
                                </a>
                            </div>

                            <div>
                                <h4 class="text-yellow-400 font-semibold mb-2 flex items-center">
                                    <i class="fas fa-screwdriver-wrench text-2xl mr-3"></i>Technical Support
                                </h4>
                                <a href="mailto:support@typhonmachinery.com" class="text-gray-600 hover:text-yellow-400 transition text-sm break-all">
                                    support@typhonmachinery.com
                                </a>
                            </div>

                            <div>
                                <h4 class="text-yellow-400 font-semibold mb-2 flex items-center">
                                    <i class="fas fa-phone text-2xl mr-3"></i>Sales Inquiries
                                </h4>
                                <a href="tel:+12132142203" class="text-gray-600 hover:text-yellow-400 transition text-sm">+1 213-214-2203</a>
                            </div>

                            <div>
                                <h4 class="text-yellow-400 font-semibold mb-2 flex items-center">
                                    <i class="fas fa-location-dot text-2xl mr-3"></i>Location
                                </h4>
                                <p class="text-gray-600 text-sm">2522 S Malt Ave. Commerce, CA 90040 United States</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="contact-card rounded-xl p-8">
                        <h3 class="text-xl font-bold text-gray-950 mb-4 flex items-center">
                            <i class="fas fa-headset text-yellow-500 mr-3"></i>Response Time
                        </h3>
                        <p class="text-gray-600 text-sm">
                            Please include the equipment model, attachment type, and any compatibility requirements so the team can respond with useful next steps.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
</body>
</html>
