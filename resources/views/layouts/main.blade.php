<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (!isset($metaTags))
        <meta name="description"
            content="UMRI Press adalah platform publikasi yang kredibel untuk karya ilmiah, buku akademik, dan jurnal penelitian dengan standar mutu internasional.">
        <meta name="keywords"
            content="UMRI Press, publikasi akademik, penerbitan buku, jurnal penelitian, Universitas Muhammadiyah Riau, buku akademik, karya ilmiah">
        <meta property="og:description"
            content="UMRI Press adalah platform publikasi yang kredibel untuk karya ilmiah, buku akademik, dan jurnal penelitian dengan standar mutu internasional.">
        <meta property="og:image" content="{{ asset('assets/img/banner/universitas.jpg') }}">
        <meta name="twitter:description"
            content="UMRI Press adalah platform publikasi yang kredibel untuk karya ilmiah, buku akademik, dan jurnal penelitian dengan standar mutu internasional.">
        <meta name="twitter:image" content="{{ asset('assets/img/banner/universitas.jpg') }}">
    @endif

    {{ $metaTags ?? '' }}

    <meta name="author" content="Universitas Muhammadiyah Riau">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ config('app.name', 'UMRI Press') }}">
    <meta property="og:locale" content="id_ID">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">

    <title>{{ isset($title) ? $title . ' | ' : '' }}{{ config('app.name', 'UMRI Press') }}</title>
    <meta property="og:title"
        content="{{ isset($title) ? $title . ' | ' : '' }}{{ config('app.name', 'UMRI Press') }}">
    <meta name="twitter:title"
        content="{{ isset($title) ? $title . ' | ' : '' }}{{ config('app.name', 'UMRI Press') }}">

    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-white dark:bg-neutral-950">

    @include('home.partials.navbar')

    <button id="backToTopBtn"
        class="fixed bottom-6 right-6 p-3 rounded-full bg-cgreen-600 text-white shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-cgreen-700 focus:outline-none focus:ring-2 focus:ring-cgreen-400 transform hover:scale-110 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
        <span class="sr-only">Back to top</span>
    </button>


    <main>
        @if (!request()->routeIs('home'))
            <x-breadcrumb />
        @endif

        <div class="{{ !request()->routeIs('home') ? 'mt-8' : '' }} min-h-screen">
            {{ $slot }}
        </div>
    </main>


    @include('home.partials.footer')


    @stack('scripts')
    @livewireScripts
</body>

</html>
