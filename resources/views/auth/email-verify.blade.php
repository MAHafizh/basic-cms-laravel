<x-layout>
    <x-slot:title>{{ $title }}</x-slot> {{-- x-slot untuk mengirim title yang dikirim dari web.php ke layout --}}
    <div
        class="mx-auto grid max-w-screen-xl rounded-lg bg-gray-50 p-4 dark:bg-gray-800 md:p-8 lg:grid-cols-12 lg:gap-8 lg:p-16 xl:gap-16">
        <div class="me-auto place-self-center lg:col-span-7">
            <h1 class="mb-3 text-2xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-4xl">
                We have sent a verification link to your email.
            </h1>
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-5 py-3 text-center text-base font-medium text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Send Verification Email
                </button>
            </form>
        </div>
    </div>
</x-layout>
