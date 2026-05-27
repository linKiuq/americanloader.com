@if ($errors->any())
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
        <p class="font-bold">Please correct the following fields:</p>
        <ul class="mt-2 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-6 lg:grid-cols-[1fr_300px]">
    <div class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div>
            <label for="title" class="mb-2 block text-sm font-bold">Title</label>
            <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" required class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
        </div>
        <div>
            <label for="slug" class="mb-2 block text-sm font-bold">URL Slug <span class="font-normal text-slate-500">(leave blank to create from title)</span></label>
            <input id="slug" type="text" name="slug" value="{{ old('slug', $post->slug) }}" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
        </div>
        <div>
            <label for="excerpt" class="mb-2 block text-sm font-bold">Excerpt</label>
            <textarea id="excerpt" name="excerpt" rows="3" required class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>
        <div>
            <label for="content" class="mb-2 block text-sm font-bold">Article Content</label>
            <textarea id="content" name="content" rows="16" required class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">{{ old('content', $post->content) }}</textarea>
            <p class="mt-2 text-xs text-slate-500">Use blank lines to separate paragraphs. HTML is displayed as plain text for safety.</p>
        </div>
    </div>

    <aside class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <label class="flex items-center gap-3 font-bold">
                <input type="checkbox" name="is_published" value="1" class="h-5 w-5 accent-yellow-500" @checked(old('is_published', $post->is_published))>
                Published
            </label>
            <p class="mt-3 text-xs leading-5 text-slate-500">Published articles appear immediately on the public blog.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <label for="image_url" class="mb-2 block text-sm font-bold">Featured Image URL</label>
            <input id="image_url" type="url" name="image_url" value="{{ old('image_url', $post->image_url) }}" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-yellow-500 focus:outline-none">
        </div>
        <button type="submit" class="w-full rounded-lg bg-yellow-400 px-6 py-4 text-sm font-black uppercase tracking-wider text-slate-950 hover:bg-yellow-500">Save Post</button>
    </aside>
</div>
