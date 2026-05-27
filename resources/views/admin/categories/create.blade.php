@extends('admin.layout')

@section('title', 'New Category')

@section('content')
    <div class="mx-auto max-w-2xl">
        <p class="text-xs font-black uppercase tracking-[0.3em] text-yellow-600">Categories</p>
        <h1 class="mb-8 mt-3 text-4xl font-black">New Category</h1>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            @include('admin.categories._form')
        </form>
    </div>
@endsection
