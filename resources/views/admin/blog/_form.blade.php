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
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="category_id" class="mb-2 block text-sm font-bold">Category</label>
                <select id="category_id" name="category_id" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
                    <option value="">No category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('category_id', $post->category_id) === $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <a href="{{ route('admin.categories.create') }}" class="mt-2 inline-block text-xs font-bold text-yellow-600 hover:text-yellow-700">Add a category</a>
            </div>
            <div>
                <label for="tags" class="mb-2 block text-sm font-bold">Tags</label>
                @php($selectedTags = collect(old('tags', $post->exists ? $post->tags->pluck('id')->all() : []))->map(fn ($id) => (int) $id)->all())
                <select id="tags" name="tags[]" multiple class="h-32 w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-yellow-500 focus:outline-none">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" @selected(in_array($tag->id, $selectedTags, true))>{{ $tag->name }}</option>
                    @endforeach
                </select>
                <a href="{{ route('admin.tags.create') }}" class="mt-2 inline-block text-xs font-bold text-yellow-600 hover:text-yellow-700">Add tags</a>
            </div>
        </div>
        <div>
            <label for="content" class="mb-2 block text-sm font-bold">Article Content</label>
            <div class="overflow-hidden rounded-lg border border-slate-300 bg-white focus-within:border-yellow-500">
                <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 bg-slate-50 px-3 py-2 text-xs font-black uppercase tracking-wider text-slate-700">
                    <button type="button" data-markdown-command="heading" data-level="1" class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">H1</button>
                    <button type="button" data-markdown-command="heading" data-level="2" class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">H2</button>
                    <button type="button" data-markdown-command="heading" data-level="3" class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">H3</button>
                    <button type="button" data-markdown-command="heading" data-level="4" class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">H4</button>
                    <button type="button" data-markdown-command="heading" data-level="5" class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">H5</button>
                    <button type="button" data-markdown-command="heading" data-level="6" class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">H6</button>
                    <button type="button" data-markdown-command="wrap" data-before="**" data-after="**" class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">B</button>
                    <button type="button" data-markdown-command="wrap" data-before="*" data-after="*" class="rounded border border-slate-300 bg-white px-3 py-2 italic hover:border-yellow-500 hover:text-yellow-700">I</button>
                    <button type="button" data-markdown-command="line-prefix" data-prefix="- " class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">List</button>
                    <button type="button" data-markdown-command="line-prefix" data-prefix="> " class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">Quote</button>
                    <button type="button" data-markdown-command="link" class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">Link</button>
                    <button type="button" data-markdown-command="image-url" class="rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">Image URL</button>
                    <label class="cursor-pointer rounded border border-slate-300 bg-white px-3 py-2 hover:border-yellow-500 hover:text-yellow-700">
                        Upload Image
                        <input type="file" accept="image/*" data-markdown-image-upload class="sr-only">
                    </label>
                    <span data-markdown-upload-status class="normal-case tracking-normal text-slate-500"></span>
                </div>
                <textarea id="content" name="content" rows="18" required class="w-full border-0 px-4 py-3 font-mono text-sm leading-7 focus:outline-none">{{ old('content', $post->content) }}</textarea>
            </div>
            <p class="mt-2 text-xs text-slate-500">Use Markdown for headings, links, lists, and images. Paste an image file or image URL directly into the editor, or use Upload Image.</p>
            <div class="mt-6 rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-100 bg-slate-50 px-5 py-3">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">Visual Preview</p>
                </div>
                <div data-article-preview class="min-h-40 px-5 py-5 text-sm leading-7 text-slate-700 [&_a]:font-semibold [&_a]:text-yellow-700 [&_h2]:mb-4 [&_h2]:mt-7 [&_h2]:text-2xl [&_h2]:font-black [&_h2]:leading-tight [&_h2]:text-slate-950 [&_h3]:mb-3 [&_h3]:mt-6 [&_h3]:text-xl [&_h3]:font-black [&_h3]:text-slate-950 [&_img]:my-5 [&_img]:max-h-[430px] [&_img]:max-w-full [&_img]:rounded-sm [&_img]:object-contain [&_p]:my-3"></div>
            </div>
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

<script>
    (() => {
        const textarea = document.getElementById('content');
        const status = document.querySelector('[data-markdown-upload-status]');
        const uploadInput = document.querySelector('[data-markdown-image-upload]');
        const preview = document.querySelector('[data-article-preview]');
        const imageUploadUrl = @json(route('admin.blog.images.store'));
        const csrfToken = @json(csrf_token());

        if (!textarea) {
            return;
        }

        const setStatus = (message) => {
            if (!status) {
                return;
            }

            status.textContent = message;
        };

        const escapeHtml = (value) => value
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

        const imageUrlPattern = /(?<!src=")(?<!href=")https?:\/\/[^\s<>()]+?\.(?:png|jpe?g|webp|gif|avif)(?:\?[^\s<>()]*)?/gi;

        const looksLikePlainHeading = (line) => {
            const trimmed = line.trim();

            if (!trimmed || trimmed.startsWith('#') || trimmed.startsWith('![') || trimmed.startsWith('- ') || trimmed.startsWith('> ')) {
                return false;
            }

            if (trimmed.includes('://') || /[.!?]$/.test(trimmed) || trimmed.length > 95) {
                return false;
            }

            const words = trimmed.match(/\b[\p{L}][\p{L}'-]*\b/gu) || [];

            if (words.length < 2 || words.length > 12) {
                return false;
            }

            const smallWords = new Set(['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'from', 'in', 'into', 'of', 'on', 'or', 'the', 'to', 'with', 'your']);
            const titleWords = words.filter((word) => /^[A-Z]/.test(word) || smallWords.has(word.toLowerCase())).length;

            return titleWords / words.length >= 0.75;
        };

        const renderInline = (text) => {
            let escaped = escapeHtml(text);

            escaped = escaped.replace(/!\[([^\]]*)\]\(([^)]+)\)/g, '<img src="$2" alt="$1">');
            escaped = escaped.replace(imageUrlPattern, '<img src="$&" alt="Article image">');
            escaped = escaped.replace(/\[([^\]]+)\]\((https?:\/\/[^)]+)\)/g, '<a href="$2">$1</a>');

            return escaped;
        };

        const updatePreview = () => {
            if (!preview) {
                return;
            }

            const blocks = textarea.value
                .split(/\n{2,}/)
                .map((block) => block.trim())
                .filter(Boolean);

            if (!blocks.length) {
                preview.innerHTML = '<p class="text-slate-400">Paste article content to preview it here.</p>';
                return;
            }

            preview.innerHTML = blocks.map((block) => {
                const lines = block.split('\n').map((line) => line.trim()).filter(Boolean);

                if (lines.length === 1) {
                    const line = lines[0];
                    const heading = line.match(/^(#{1,6})\s+(.+)$/);

                    if (heading) {
                        const level = Math.min(6, heading[1].length);
                        return `<h${level}>${escapeHtml(heading[2])}</h${level}>`;
                    }

                    if (looksLikePlainHeading(line)) {
                        return `<h2>${escapeHtml(line)}</h2>`;
                    }
                }

                return `<p>${renderInline(lines.join(' '))}</p>`;
            }).join('');
        };

        const selection = () => ({
            start: textarea.selectionStart,
            end: textarea.selectionEnd,
            value: textarea.value.slice(textarea.selectionStart, textarea.selectionEnd),
        });

        const replaceSelection = (replacement, cursorOffset = replacement.length) => {
            const { start, end } = selection();
            textarea.setRangeText(replacement, start, end, 'end');
            textarea.focus();
            textarea.setSelectionRange(start + cursorOffset, start + cursorOffset);
            updatePreview();
        };

        const prefixSelectedLines = (prefix) => {
            const { value } = selection();
            const text = value || 'New line';
            replaceSelection(text.split('\n').map((line) => `${prefix}${line}`).join('\n'));
        };

        const insertImageMarkdown = (url, alt = 'Blog image') => {
            replaceSelection(`![${alt}](${url})`);
        };

        const uploadImage = async (file) => {
            if (!file || !file.type.startsWith('image/')) {
                return;
            }

            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('image', file);

            setStatus('Uploading image...');

            try {
                const response = await fetch(imageUploadUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        Accept: 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Upload failed');
                }

                const data = await response.json();
                insertImageMarkdown(data.url, file.name.replace(/\.[^.]+$/, '') || 'Blog image');
                setStatus('Image inserted');
                window.setTimeout(() => setStatus(''), 2500);
            } catch (error) {
                setStatus('Image upload failed');
            }
        };

        document.querySelectorAll('[data-markdown-command]').forEach((button) => {
            button.addEventListener('click', () => {
                const command = button.dataset.markdownCommand;
                const { value } = selection();

                if (command === 'heading') {
                    prefixSelectedLines(`${'#'.repeat(Number(button.dataset.level || 2))} `);
                }

                if (command === 'wrap') {
                    const before = button.dataset.before || '';
                    const after = button.dataset.after || before;
                    replaceSelection(`${before}${value || 'text'}${after}`, before.length + (value || 'text').length);
                }

                if (command === 'line-prefix') {
                    prefixSelectedLines(button.dataset.prefix || '');
                }

                if (command === 'link') {
                    const text = value || 'link text';
                    replaceSelection(`[${text}](https://example.com)`, text.length + 3);
                }

                if (command === 'image-url') {
                    replaceSelection('![Image alt](https://example.com/image.jpg)', 12);
                }
            });
        });

        uploadInput?.addEventListener('change', (event) => {
            uploadImage(event.target.files?.[0]);
            event.target.value = '';
        });

        textarea.addEventListener('input', updatePreview);

        textarea.addEventListener('paste', (event) => {
            const image = Array.from(event.clipboardData?.files || []).find((file) => file.type.startsWith('image/'));

            if (image) {
                event.preventDefault();
                uploadImage(image);
            }
        });

        updatePreview();
    })();
</script>
