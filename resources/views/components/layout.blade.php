<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if($title) <title>Scouts Baslac - {{ $title }}</title>
    @else <title>Scouts Baslac</title>
    @endif

    @vite('resources/css/app.css')
    
    @if($csslinks) {{ $csslinks }}
    @endif
    @if($jslinks) {{ $jslinks }}
    @endif
</head>
<body class="w-full h-screen flex laptop:flex-row flex-col dark:bg-black dark:text-white">
    @include('prefab.menu-list')
    {{ $slot }}
</body>
</html>