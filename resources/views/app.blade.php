<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    @php
      $defaultSeo = [
          'title' => 'Business Awards | Celebrating Business Excellence',
          'description' => 'Business Awards inatambua na kuenzi mshikamano, ubunifu, na mafanikio ya viongozi, mashirika, na kampuni zinazochangia maendeleo ya biashara nchini Tanzania.',
          'image' => rtrim(config('app.url'), '/') . '/images/logo.png',
          'url' => url()->current(),
          'type' => 'website',
      ];

      $pageSeo = $page['props']['seo'] ?? [];
      $seo = array_merge($defaultSeo, $pageSeo, $seo ?? []);
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Inertia title fallback -->
    <title inertia>{{ $seo['title'] }}</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/web-app-manifest-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/web-app-manifest-512x512.png">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="rgb(159, 138, 4)">
    <meta name="msapplication-TileColor" content="rgb(231, 149, 8)">
    <meta name="msapplication-config" content="/browserconfig.xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- ================== SEO MABORESHO ================== -->
    <!-- Description -->
    <meta name="description" content="{{ $seo['description'] }}">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:site_name" content="Business Awards">
    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta property="og:url" content="{{ $seo['url'] }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:image" content="{{ $seo['image'] }}">
    <meta property="og:image:secure_url" content="{{ $seo['image'] }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:image:alt" content="Business Awards Logo">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    <meta name="twitter:image" content="{{ $seo['image'] }}">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead
  </head>
  <body class="font-sans antialiased">
    @inertia
  </body>
</html>
