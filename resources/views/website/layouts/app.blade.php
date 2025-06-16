<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoomYatra - Find Your Perfect Room</title>
    @vite('resources/css/app.css')
    @yield('styles')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navigation -->
    @include('website.layouts.partial.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('website.layouts.partial.footer')

    @yield('scripts')
</body>

</html>
