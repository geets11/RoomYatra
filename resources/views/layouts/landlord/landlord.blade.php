<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landlord Dashboard - RoomYatra</title>
    @vite('resources/css/app.css')
    @stack('styles')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen ">
    <!-- Navigation -->
    @include('layouts.landlord.partials.navigation')

    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.landlord.partials.footer')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')
</body>

</html>
