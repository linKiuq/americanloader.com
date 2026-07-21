<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>Admin Login - The Power Loader</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 font-sans text-white antialiased">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-5 py-12">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(250,204,21,0.18),transparent_32%),linear-gradient(135deg,#020617_0%,#111827_52%,#020617_100%)]"></div>
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-yellow-300/70 to-transparent"></div>

        <section class="relative w-full max-w-md rounded-2xl border border-white/10 bg-white/[0.06] p-7 shadow-2xl shadow-black/40 backdrop-blur sm:p-8">
            <a href="{{ route('welcome') }}" class="mb-8 inline-flex items-center gap-3 text-sm font-black uppercase tracking-[0.16em] text-white">
                <img src="{{ asset('power-loader-logo.png') }}" alt="" class="h-12 w-12 object-contain">
                <span>The Power Loader</span>
            </a>

            <p class="text-xs font-black uppercase tracking-[0.28em] text-yellow-300">Secure Access</p>
            <h1 class="mt-4 text-3xl font-black leading-tight text-white" style="font-family: 'Montserrat', sans-serif;">Admin Dashboard Login</h1>
            <p class="mt-3 text-sm leading-6 text-slate-300">Sign in to manage dashboard content, blog posts, categories, and tags.</p>

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-sm font-bold text-slate-100">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="w-full rounded-lg border border-white/15 bg-white/95 px-4 py-3 text-slate-950 outline-none transition focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20">
                    @error('email')
                        <p class="mt-2 text-sm font-semibold text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-bold text-slate-100">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full rounded-lg border border-white/15 bg-white/95 px-4 py-3 text-slate-950 outline-none transition focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20">
                    @error('password')
                        <p class="mt-2 text-sm font-semibold text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-3 text-sm font-semibold text-slate-300">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-white/20 accent-yellow-400">
                    Remember me
                </label>

                <button type="submit" class="w-full rounded-lg bg-yellow-400 px-6 py-4 text-sm font-black uppercase tracking-[0.14em] text-slate-950 transition hover:bg-yellow-300 focus:outline-none focus:ring-4 focus:ring-yellow-400/30">Sign In</button>
            </form>
        </section>
    </main>
</body>
</html>
