<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPT App</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
    @include('partials.header')

    <main class="flex-1 dark:bg-[#18181c]">
        @yield('content')
    </main>

    @include('partials.footer')
</body>

</html>
