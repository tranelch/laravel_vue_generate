<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'App Name') }}</title>

        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="preload" href="/i/liquidfreight_logo.png" as="image" />

        <!-- PWA Tags -->
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#AB2328">
        <meta name="mobile-wep-app-capable" content="yes">
        <meta name="apple-mobile-wep-app-capable" content="yes">
        <link rel="apple-touch-icon" href="/i/pwa/icons/icon-192x192.png">

        <!-- Styles -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <meta http-equiv="Content-Security-Policy" content="
            default-src 'self';
            script-src 'self' 'unsafe-inline' 'unsafe-eval' https://maps.googleapis.com;
            connect-src 'self' https://maps.googleapis.com;
            font-src 'self' data: https://fonts.bunny.net https://cdnjs.cloudflare.com;
            style-src-elem 'unsafe-inline' 'self' https://fonts.bunny.net https://cdnjs.cloudflare.com;
            style-src 'unsafe-inline' https://cdnjs.cloudflare.com;
            img-src data: w3.org/svg/2000 'self' https://gravatar.com;
        ">

        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js');
                });
            }
        </script>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        @env ('local')
            <!--<script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>-->
        @endenv
    </body>
</html>
