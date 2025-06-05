{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Job Scraper')</title>

    {{-- Include compiled Tailwind + WireUI CSS --}}
    @vite('resources/css/app.css')

    @livewireStyles
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-semibold text-indigo-600">JobScraper</a>
            {{-- You can add nav links here if needed --}}
        </div>
    </header>

    <main class="flex-1 container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <footer class="bg-white border-t">
        <div class="container mx-auto px-4 py-4 text-sm text-gray-600 text-center">
            &copy; {{ now()->year }} JobScraper. All rights reserved.
        </div>
    </footer>

    {{-- Alpine + WireUI JS (bundled via Vite) --}}
    @vite('resources/js/app.js')
    @livewireScripts
</body>

</html>
