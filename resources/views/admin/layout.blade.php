<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>@yield('title', 'Blog Admin') - Skoop Loaders</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-950 antialiased">
    <header class="border-b border-yellow-400/15 bg-slate-950 text-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
            <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-3 font-black uppercase tracking-wider">
                <img src="{{ asset('logo.png') }}" alt="" class="h-11 w-11 object-contain">
                <span>Blog Admin</span>
            </a>
            <div class="flex items-center gap-5 text-sm">
                <a href="{{ route('blog.index') }}" class="font-semibold text-slate-300 hover:text-yellow-400">View Blog</a>
                @auth
                    <a href="{{ route('admin.password.edit') }}" class="font-semibold text-slate-300 hover:text-yellow-400">Password</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="rounded border border-yellow-400/50 px-4 py-2 font-bold uppercase tracking-wider text-yellow-400 hover:bg-yellow-400 hover:text-slate-950">Log Out</button>
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
