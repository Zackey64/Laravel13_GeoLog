<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'GeoLog' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

    <x-header />

    <main class="w-full flex-1 mx-auto max-w-7xl px-4 py-0">
        {{ $slot }}
    </main>

    <x-footer />
    
</body>
</html>