<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>@yield('title', 'Admin Dashboard') - The Power Loader</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 font-sans text-[#071d38] antialiased">
    <header class="border-b border-red-500/15 bg-[#071d38] text-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 font-black uppercase tracking-wider">
                <img src="{{ asset('american-loader-logo.webp') }}" alt="American Loader" class="h-11 w-24 object-contain">
                <span>Admin Dashboard</span>
            </a>
            <div class="flex items-center gap-5 text-sm">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="font-semibold text-slate-300 hover:text-red-500">Dashboard</a>
                    <a href="{{ route('admin.blog.index') }}" class="font-semibold text-slate-300 hover:text-red-500">Posts</a>
                    <a href="{{ route('admin.categories.index') }}" class="font-semibold text-slate-300 hover:text-red-500">Categories</a>
                    <a href="{{ route('admin.tags.index') }}" class="font-semibold text-slate-300 hover:text-red-500">Tags</a>
                @endauth
                <a href="{{ route('blog.index') }}" class="font-semibold text-slate-300 hover:text-red-500">View Blog</a>
                @auth
                    <a href="{{ route('admin.password.edit') }}" class="font-semibold text-slate-300 hover:text-red-500">Password</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="rounded border border-red-500/50 px-4 py-2 font-bold uppercase tracking-wider text-red-500 hover:bg-red-500 hover:text-white">Log Out</button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-10">
        @if (session('success'))
            <div class="mb-7 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
