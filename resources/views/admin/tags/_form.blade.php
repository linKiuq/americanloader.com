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

<div class="space-y-6 rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
    <div>
        <label for="name" class="mb-2 block text-sm font-bold">Tag Name</label>
        <input id="name" type="text" name="name" value="{{ old('name', $tag->name) }}" required class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
    </div>
    <div>
        <label for="slug" class="mb-2 block text-sm font-bold">URL Slug <span class="font-normal text-slate-500">(leave blank to create from name)</span></label>
        <input id="slug" type="text" name="slug" value="{{ old('slug', $tag->slug) }}" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
    </div>
    <button type="submit" class="rounded-lg bg-yellow-400 px-7 py-4 text-sm font-black uppercase tracking-wider text-slate-950 hover:bg-yellow-500">Save Tag</button>
</div>
