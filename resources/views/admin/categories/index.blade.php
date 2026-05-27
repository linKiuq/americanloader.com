@extends('admin.layout')

@section('title', 'Manage Categories')

@section('content')
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.3em] text-yellow-600">Content Organization</p>
            <h1 class="mt-3 text-4xl font-black" style="font-family: 'Montserrat', sans-serif;">Categories</h1>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="rounded-lg bg-yellow-400 px-6 py-4 text-center text-sm font-black uppercase tracking-wider text-slate-950 hover:bg-yellow-500">New Category</a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-950 text-xs uppercase tracking-wider text-slate-300">
                <tr>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Articles</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-6 py-5">
                            <p class="font-bold">{{ $category->name }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $category->slug }}</p>
                        </td>
                        <td class="px-6 py-5 text-slate-600">{{ $category->blog_posts_count }}</td>
                        <td class="px-6 py-5">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="font-bold text-yellow-600 hover:text-yellow-700">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? Its articles will remain available.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-bold text-red-600 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-6 py-12 text-center text-slate-500">No categories have been created.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($categories->hasPages())
        <div class="mt-8">{{ $categories->links() }}</div>
    @endif
@endsection
