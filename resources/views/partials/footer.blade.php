<footer class="bg-white border-t border-gray-200 px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('power-loader-logo.png') }}" alt="Power Loader" class="h-16 w-16 object-contain">
                    <span class="text-gray-950 font-black text-lg uppercase tracking-tight">Skoop <span class="text-yellow-600">Loaders</span></span>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Compact loaders, excavators, forklifts, attachments, and jobsite equipment built for practical daily work.
                </p>
            </div>

            <div>
                <h4 class="text-gray-950 font-bold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('welcome') }}" class="text-gray-600 hover:text-yellow-600 transition">Home</a></li>
                    <li><a href="{{ route('equipment') }}" class="text-gray-600 hover:text-yellow-600 transition">Equipment</a></li>
                    <li><a href="{{ route('attachments.index') }}" class="text-gray-600 hover:text-yellow-600 transition">Attachments</a></li>
                    <li><a href="{{ route('cart') }}" class="text-gray-600 hover:text-yellow-600 transition">Cart</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-600 hover:text-yellow-600 transition">About</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-yellow-600 transition">Contact</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-gray-950 font-bold mb-4">Support</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('equipment') }}" class="text-gray-600 hover:text-yellow-600 transition">Browse Products</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-yellow-600 transition">Request Quote</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-yellow-600 transition">Parts & Service</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-yellow-600 transition">Warranty Help</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-gray-950 font-bold mb-4">Contact</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><a href="mailto:digital@typhonmachinery.com" class="hover:text-yellow-600 transition">digital@typhonmachinery.com</a></p>
                    <p><a href="tel:+15551234567" class="hover:text-yellow-600 transition">+1 (555) 123-4567</a></p>
                    <p>Commerce, CA 90040</p>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-gray-200 pt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-gray-500 text-sm">&copy; 2026 The Power Loader. All rights reserved.</p>
            <div class="flex gap-5 text-sm font-semibold">
                <a href="{{ route('equipment') }}" class="text-gray-500 hover:text-yellow-600 transition">Shop</a>
                <a href="{{ route('cart') }}" class="text-gray-500 hover:text-yellow-600 transition">Cart</a>
                <a href="{{ route('about') }}" class="text-gray-500 hover:text-yellow-600 transition">Company</a>
                <a href="{{ route('contact') }}" class="text-gray-500 hover:text-yellow-600 transition">Support</a>
            </div>
        </div>
    </div>
</footer>
