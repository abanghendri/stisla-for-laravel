<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- General CSS Files -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('vendor/iziToast/iziToast.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet"
        href="{{ mix('css/app.css') }}?_{!! substr(str_shuffle('0123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz'),1,12) !!}">
    <link rel="stylesheet"
        href="{{ mix('css/components.css') }}?_{!! substr(str_shuffle('0123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz'),1,12) !!}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <!-- <x-jet-banner /> -->

            @include('layouts.topbar')
            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                {{ $slot }}
                <!-- <section class="section">
                    <div class="section-header">
                        <h1> </h1>
                        <div class="section-header-button">
                            <a href="features-post-create.html" class="btn btn-primary">Add New</a>
                        </div>
                    </div>

                    <div class="section-body">
                        
                    </div>
                </section> -->
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad
                        Nauval Azhar</a>
                </div>
                <div class="footer-right">
                    2.3.0
                </div>
            </footer>
        </div>
    </div>
    stack('modals')

    @livewireScripts


    <!-- General JS Scripts -->


    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ mix('js/app.js')}}"></script>
    <script src="{{ asset('vendor/iziToast/iziToast.min.js') }}"></script>
    <!-- Page Specific JS File -->
    @stack('scripts')


</body>

</html>
