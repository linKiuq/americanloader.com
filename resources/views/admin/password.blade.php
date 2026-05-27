@extends('admin.layout')

@section('title', 'Change Password')

@section('content')
    <div class="mx-auto max-w-xl rounded-2xl border border-slate-200 bg-white p-7 shadow-sm sm:p-10">
        <p class="text-xs font-black uppercase tracking-[0.32em] text-yellow-600">Administrator</p>
        <h1 class="mt-3 font-['Montserrat'] text-3xl font-black uppercase">Change Password</h1>
        <p class="mt-3 text-sm leading-6 text-slate-600">Replace your temporary password after your first sign in.</p>

        <form method="POST" action="{{ route('admin.password.update') }}" class="mt-8 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="mb-2 block text-sm font-bold">Current password</label>
                <input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
                @error('current_password')
                    <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-bold">New password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
                <p class="mt-2 text-xs text-slate-500">Use at least 12 characters.</p>
                @error('password')
                    <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-bold">Confirm new password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
            </div>

            <button type="submit" class="w-full rounded-lg bg-yellow-400 px-6 py-4 text-sm font-black uppercase tracking-wider text-slate-950 transition hover:bg-yellow-500">
                Update Password
            </button>
        </form>
    </div>
@endsection
