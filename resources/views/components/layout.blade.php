<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <title>Home</title>
</head>

<body class="h-full">
    <div class="min-h-full">
        <x-navbar></x-navbar> {{-- php artisan make:component Navbar --}}
        <x-header>{{ $title }}</x-header> {{-- php artisan make:component Header --}}
        <main>
            <div class="mx-auto max-w-7xl py-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>

</body>

</html>
