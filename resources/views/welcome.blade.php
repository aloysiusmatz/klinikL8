<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@include('inc.companyname')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="     fixed top-0 right-0 px-6 py-4">
                    @auth
                        <a href="{{ route('medrec.index') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif

                    @endauth    
                </div>
            @endif

            
            
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class=" text-gray-600 dark:text-gray-400 text-9xl">
                    @include('inc.companyname')
                </div>
                <div class=" mt-1 text-gray-600 dark:text-gray-400 text-md text-center">
                    
                </div>
            </div>
        </div>
    </body>
</html>
