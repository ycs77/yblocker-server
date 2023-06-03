<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="robots" content="noindex, nofollow">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @inertiaHead
    @vite('resources/js/app.ts')
</head>

<body class="font-sans antialiased">
    @inertia
</body>
</html>
