@extends('admin.layout')

@section('title', 'New Tag')

@section('content')
    <div class="mx-auto max-w-2xl">
        <p class="text-xs font-black uppercase tracking-[0.3em] text-yellow-600">Tags</p>
        <h1 class="mb-8 mt-3 text-4xl font-black">New Tag</h1>
        <form method="POST" action="{{ route('admin.tags.store') }}">
            @csrf
            @include('admin.tags._form')
        </form>
    </div>
@endsection
