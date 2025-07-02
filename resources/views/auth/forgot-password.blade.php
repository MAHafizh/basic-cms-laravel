<x-layout>
    <x-slot:title>{{ $title }}</x-slot> {{-- x-slot untuk mengirim title yang dikirim dari web.php ke layout --}}
    <div
        class="mx-auto grid max-w-screen-xl rounded-lg bg-gray-50 p-4 dark:bg-gray-800 md:p-8 lg:grid-cols-12 lg:gap-8 lg:p-16 xl:gap-16">
        <div class="me-auto place-self-center lg:col-span-7">
            <h1 class="mb-3 text-2xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-4xl">
                Forgot Your Password?
            </h1>
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-white">Your Email</label>
                    <input type="email" name="email" id="email" placeholder="name@company.com"
                        class="bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required="">
                </div>
                <button type="submit"
                    class="w-full mt-4 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Send Password Reset Link
                </button>
            </form>
            @if (session('status'))
                <p>{{ session('status') }}</p>
            @endif
        </div>
    </div>
</x-layout>
