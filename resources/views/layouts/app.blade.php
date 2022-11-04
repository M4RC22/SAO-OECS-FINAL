<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SAO OECS') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        {{-- Screen Loading --}}
        <script defer src="{{ asset('js/screen-loader.js') }}"></script>

        {{-- Papaparse --}}
        <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.1/papaparse.min.js"></script>

        {{-- Table Handler --}}
        <script src="{{ asset('js/table-handler.js') }}" defer></script>

        {{-- Session Storage Handler--}}
        <script src="{{ asset('js/session-storage-handler.js') }}" defer></script>

        {{-- Calendar Handler--}}
        <script src="{{ asset('js/calendar.js') }}" defer></script>

        {{-- Confirmation of Input for Cancel--}}
        <script src="{{ asset('js/confirmation-input.js') }}" defer></script>

        {{-- Image Upload Handler --}}
        <script src="{{ asset('js/image-upload.js') }}" defer></script>

        {{-- Search Handler --}}
        <script src="{{ asset('js/search.js') }}" defer></script>

        {{-- Edit Handler --}}
        <script src="{{ asset('js/edit-handler.js') }}" defer></script>

         {{-- APF Handler --}}
         <script src="{{ asset('js/APF-handler.js') }}" defer></script>


         {{-- Charts External Link--}}
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
         <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <body class="font-sans antialiased">
        <div class="relative min-h-screen bg-gray-100 lg:pl-64">
            
            <!-- Page Heading -->
            <header class="flex items-center h-auto" x-data="{ open: false }">
                <nav class="relative flex items-center w-full">
                    @include('partials.__navigation')
                    @include('partials.__sidebar')
                </nav>
            </header>

            <!-- Page Content -->
            <main class="pb-24" x-data="loader()">
                {{ $slot }}
            </main>

            <!-- Page Footer -->
            <footer>
                @include('partials.__footer')
            </footer> 
           
        </div>

        {{--
            
            !! Comment this out to turn off loading screen !!

        --}}
        <div id="loader" class="hidden">
            <div class="flex flex-col space-y-6 items-center justify-center z-50 fixed top-0 left-0 w-screen h-screen bg-slate-300 bg-opacity-60">
                <img src="{{ asset('assets/svg/screen-loader-animation/ball-triangle.svg') }}" alt="">
                <p class="text-sm text-gray-500">Loading...</p>
            </div> 
        </div>
      
    </body>
</html>
