<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

@vite('resources/css/app.css')

</head>
<body class="guest-body">

    <!-- header (keeps it minimal like your screenshot) -->
    <header class="site-header">
        <!-- you can put logo or app name here if you want -->
    </header>

    <!-- content will be injected here via $slot -->
    <main class="guest-main">
        {{ $slot }}
    </main>

    <footer class="site-footer">
        <!-- optional footer -->
    </footer>

</body>
</html>
