<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-md sm:text-center">
            <form action="/posts" method="GET">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                <div class="items-center mx-auto mb-3 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                    <div class="relative w-full">
                        <label for="search" class="hidden mb-2 text-sm font-medium text-white">Search</label>
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-[26px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>

                        </div>
                        <input
                            class="block p-3 pl-10 w-full text-sm text-white bg-gray-800 rounded-lg sm:rounded-none sm:rounded-l-lg"
                            placeholder="Search Here" type="search" id="search" name="search" autocomplete="off">
                    </div>
                    <div>
                        <button type="submit"
                            class="py-3 px-5 w-full text-sm font-medium text-white text-center rounded-lg cursor-pointer bg-gray-800 sm:rounded-none sm:rounded-r-lg border-1 border-gray-800 hover:bg-gray-900">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <section>
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                    @forelse ($posts as $post)
                        <article class="relative rounded-lg border border-gray-200 shadow-md overflow-hidden group transition-all duration-300">
                            <a href='/posts/{{ $post['slug'] }}' class="absolute inset-0 z-10"></a>
                            <div class="absolute inset-0 bg-cover bg-center filter grayscale group-hover:grayscale-0 transition duration-500 brightness-80"
                                style="background-image: url('{{ asset('storage/' . $post->image) }}');">
                            </div>
                            {{-- <div class="absolute inset-0 bg-opacity-40"></div> --}}
                            <div
                                class="bg-opacity-80 backdrop-blur-sm p-4 rounded-lg h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-center mb-5 text-gray-500">
                                        <span
                                            class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded bg-{{ $post->category->color }}-300">
                                            <a
                                                href="/posts?category={{ $post->category->slug }}">{{ $post->category->name }}</a>
                                        </span>
                                        <span class="text-sm text-white">{{ $post->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <h2
                                        class="mb-2 text-2xl font-bold tracking-tight text-white">
                                        {{ $post['title'] }}
                                    </h2>
                                    {{-- <p class="mb-5 text-gray-700">
                                        {{ Str::limit(strip_tags(html_entity_decode($post->body)), 100) }}
                                    </p> --}}
                                </div>
                                <div class="flex justify-between items-center mt-6 pt-2 border-t border-white">
                                    <div class="flex items-center space-x-4">
                                        <img class="w-7 h-7 rounded-full"
                                            src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/jese-leos.png"
                                            alt="Jese Leos avatar" />
                                        <span class="font-medium">
                                            <a href="/posts?author={{ $post->author->username }}"
                                                class="hover:underline text-white">
                                                {{ $post->author->name }}
                                            </a>
                                        </span>
                                    </div>
                                    {{-- <a href="/posts/{{ $post['slug'] }}"
                                        class="inline-flex items-center font-medium hover:underline">
                                        Read more
                                        <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a> --}}
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="lg:w-[1120px] md:w-[918px] grid-cols-1 items-center justify-center z-40">
                            <div class="text-center">
                                <h2 class="text-2xl font-bold">No Posts Found</h2>
                                <p class="text-gray-500">Sorry, we couldn't find any posts matching your criteria.</p>
                                <a href="/posts" class="hover:underline text-blue-600">&laquo; Back to Post </a>
                            </div>
                        </div>
                    @endforelse
                </div>
        </section>
        {{ $posts->links() }}
</x-layout>
