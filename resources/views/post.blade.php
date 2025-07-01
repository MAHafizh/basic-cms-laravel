<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white antialiased">
        <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
            <article
                class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                <header class="mb-4 lg:mb-6 not-format">
                    <address class="flex items-center mb-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900">
                            <img class="mr-4 w-16 h-16 rounded-full"
                                src="https://flowbite.com/docs/images/people/profile-picture-2.jpg" alt="Jese Leos">
                            <div>
                                <a href="/posts?author={{ $post->author->username }}" rel="author"
                                    class="text-3xl font-bold text-gray-900">{{ $post->author->name }}</a>
                                <p class="text-base text-gray-600">Article In<span
                                        class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center mx-1 px-2.5 py-0.5 rounded bg-{{ $post->category->color }}-300">
                                        <a
                                            href="/posts?category={{ $post->category->slug }}">{{ $post->category->name }}</a>
                                    </span>
                                </p>
                                <p class="text-base text-gray-500 dark:text-gray-600">Published on
                                    {{ $post->created_at->format('j F Y') }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Last Update
                                    {{ $post->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </address>
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl">
                        {{ $post['title'] }}</h1>
                </header>

                <body>
                    <div class="text-black [&_*]:text-black">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Article Image"
                                class="h-64 object-contain mx-auto">
                        @endif
                        {!! $post->body !!}
                    </div>
                </body>
            </article>
        </div>
    </main>
</x-layout>

