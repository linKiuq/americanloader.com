@extends('admin.layout')

@section('title', 'Admin Login')

@section('content')
    <div class="mx-auto mt-12 max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <p class="text-xs font-black uppercase tracking-[0.3em] text-yellow-600">Secure Access</p>
        <h1 class="mt-4 text-3xl font-black" style="font-family: 'Montserrat', sans-serif;">Admin Dashboard Login</h1>
        <p class="mt-2 text-sm text-slate-600">Sign in to manage dashboard content, blog posts, categories, and tags.</p>

        <form method="POST" action="{{ route('admin.login.store') }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm font-bold">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
                @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-bold">Password</label>
                <input id="password" type="password" name="password" required class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="accent-yellow-500">
                Remember me
            </label>
            <button type="submit" class="w-full rounded-lg bg-yellow-400 px-6 py-4 text-sm font-black uppercase tracking-wider text-slate-950 hover:bg-yellow-500">Sign In</button>
        </form>
    </div>
@endsection
