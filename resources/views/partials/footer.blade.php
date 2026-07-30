<footer class="bg-white border-t border-gray-200 px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('american-loader-logo.webp') }}" alt="American Loader" class="h-20 w-auto max-w-full object-contain">
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Compact loaders, excavators, forklifts, attachments, and jobsite equipment built for practical daily work.
                </p>
            </div>

            <div>
                <h4 class="text-[#071d38] font-bold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('welcome') }}" class="text-gray-600 hover:text-red-700 transition">Home</a></li>
                    <li><a href="{{ route('equipment') }}" class="text-gray-600 hover:text-red-700 transition">Equipment</a></li>
                    <li><a href="{{ route('attachments.index') }}" class="text-gray-600 hover:text-red-700 transition">Attachments</a></li>
                    <li><a href="{{ route('cart') }}" class="text-gray-600 hover:text-red-700 transition">Cart</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-600 hover:text-red-700 transition">About</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-red-700 transition">Contact</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[#071d38] font-bold mb-4">Support</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('equipment') }}" class="text-gray-600 hover:text-red-700 transition">Browse Products</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-red-700 transition">Request Quote</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-red-700 transition">Parts & Service</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-red-700 transition">Warranty Help</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[#071d38] font-bold mb-4">Contact</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><a href="mailto:sales@typhonmachinery.com" class="hover:text-red-700 transition">sales@typhonmachinery.com</a></p>
                    <p><a href="mailto:support@typhonmachinery.com" class="hover:text-red-700 transition">support@typhonmachinery.com</a></p>
                    <p><a href="tel:+12132142203" class="hover:text-red-700 transition">+1 213-214-2203</a></p>
                    <p>2522 S Malt Ave. Commerce, CA 90040 United States</p>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-gray-200 pt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-gray-500 text-sm">&copy; 2026 The Power Loader. All rights reserved.</p>
            <div class="flex gap-5 text-sm font-semibold">
                <a href="{{ route('equipment') }}" class="text-gray-500 hover:text-red-700 transition">Shop</a>
                <a href="{{ route('cart') }}" class="text-gray-500 hover:text-red-700 transition">Cart</a>
                <a href="{{ route('about') }}" class="text-gray-500 hover:text-red-700 transition">Company</a>
                <a href="{{ route('contact') }}" class="text-gray-500 hover:text-red-700 transition">Support</a>
            </div>
        </div>
    </div>
</footer>
