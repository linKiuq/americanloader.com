@extends('admin.layout')

@section('title', 'Edit Blog Post')

@section('content')
    <div class="mb-8">
        <p class="text-xs font-black uppercase tracking-[0.3em] text-yellow-600">Blog Editor</p>
        <h1 class="mt-3 text-4xl font-black" style="font-family: 'Montserrat', sans-serif;">Edit Post</h1>
    </div>

    <form method="POST" action="{{ route('admin.blog.update', $post) }}">
        @csrf
        @method('PUT')
        @include('admin.blog._form')
    </form>
@endsection
