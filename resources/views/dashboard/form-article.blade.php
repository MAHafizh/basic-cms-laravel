<x-layout>
    <x-slot:title>{{ $title }}</x-slot> {{-- x-slot untuk mengirim title yang dikirim dari web.php ke layout --}}
    <section class="bg-white">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold">Add a new article</h2>
            <form action="{{ isset($post) ? route('post.update', $post->id) : route('post.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @if (isset($post))
                    @method('PUT')
                @endif
                <div class="grid gap-2 sm:grid-cols-2 sm:gap-4">
                    {{-- <div class="flex-col items-center justify-center sm:col-span-2">
                        <label for="image"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center py-4">
                                <svg class="w-8 h-8 mb-2 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400"><span
                                        class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p id="filename" class="mb-2 text-sm text-gray-500 dark:text-gray-400">nama file</p>
                            </div>
                            <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                        </label>
                        <div id="preview" class="mt-2">Test</div>
                    </div> --}}

                    <div class="sm:col-span-2">
                        <p id="preview"></p>
                        @if (isset($post) && $post->image)
                            <img id="old-image" src="{{ asset('storage/' . $post->image) }}" alt="Article Image"
                                class="w-64 h-auto rounded">
                        @endif
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="file_input">Upload
                            file</label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="file_input_help" id="image" type="file" name="image"
                            accept="image/*">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Image
                            (Max Size 10 MB).</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="title" class="block mb-2 text-sm font-medium">Article Title</label>
                        <input type="text" name="title" id="title"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Write Article's Title Here!" value="{{ old('title', $post->title ?? '') }}"
                            required="">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="author" class="block mb-2 text-sm font-medium">Author</label>
                        <select id="author_id" name="author_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            {{-- <option selected="">Select User (Sementara)</option> --}}
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('author_id', $post->author_id ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="category" class="block mb-2 text-sm font-medium">Category</label>
                        <select id="category_id" name="category_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            {{-- <option selected>Select category</option> --}}
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex-1 max-w-7xl mt-4">
                    <label for="category" class="block mb-2 text-sm font-medium">Write Your Article</label>
                    <x-texteditor :value="old('body', $post->body ?? '')" />
                </div>
                <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium bg-gray-800 text-white text-center rounded-lg focus:ring-4 hover:bg-gray-900">
                    {{ isset($post) ? 'Update Article' : 'Create Article' }}
                </button>
            </form>
            <script>
                document.querySelector('form').addEventListener('submit', function() {
                    tinymce.triggerSave();
                });
                const input = document.getElementById('image');
                const preview = document.getElementById('preview');
                const oldImage = document.getElementById('old-image');

                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && oldImage) {
                        oldImage.style.display = 'none'
                    }
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.innerHTML =
                                `<img src="${e.target.result}" alt="Preview" class="w-40 h-auto rounded">`;
                        }
                        reader.readAsDataURL(file);
                    } else {
                        preview.innerHTML = '';
                        if (oldImage) {
                            oldImage.style.display = 'block'
                        }
                    }

                })
            </script>
        </div>
    </section>
</x-layout>
