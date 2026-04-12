<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPT App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    @include('partials.header')

    <main class="grow container mx-auto p-4">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
