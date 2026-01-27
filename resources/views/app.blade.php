<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.ico') }}">
    <link rel="icon" href="{{ asset('favicon/favicon.ico') }}">
    <title inertia>Fleetis</title>

    @vite(['resources/js/app.js'])
    @inertiaHead
</head>
<body class="bg-gray-100">
    @inertia
</body>
</html>
