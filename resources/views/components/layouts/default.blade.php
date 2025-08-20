<!DOCTYPE html>
<html lang="en" dir="ltr" data-theme="slack">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LitePostᯓ★</title>

    <!-- Favicons -->
    
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png?v=5') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png?v=5') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon-192x192.png?v=5') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png?v=5') }}">
    <link rel="icon" href="{{ asset('favicon.ico?v=5') }}" sizes="any">

    <!-- Google Font: Rubik  -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Rubik font -->
    <style>
        .font-rubik,
        .font-rubik * {
            font-family: 'Rubik', sans-serif !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="max-w-4xl mx-auto px-4 min-h-screen flex flex-col font-rubik">
    {{ $slot }}
</body>

</html>