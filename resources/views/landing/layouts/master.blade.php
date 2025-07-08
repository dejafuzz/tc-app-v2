<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Tersimpan Cerita</title>

    @include('landing.layouts.assets.css')

</head>

<body>
    <!-- Preloader Start -->
    <div id="preloader">
        <div class="preload-content">
            <div id="sonar-load"></div>
        </div>
    </div>
    <!-- Preloader End -->

    <!-- Grids -->
    <div class="grids d-flex justify-content-between">
        <div class="grid1"></div>
        <div class="grid2"></div>
        <div class="grid3"></div>
        <div class="grid4"></div>
        <div class="grid5"></div>
        <div class="grid6"></div>
        <div class="grid7"></div>
        <div class="grid8"></div>
        <div class="grid9"></div>
    </div>

    @include('landing.layouts.assets.main-menu')

    @include('landing.layouts.assets.header')

    @yield('content')

    @include('landing.layouts.assets.footer')

    <!-- Tombol WhatsApp -->
    <a href="https://wa.me/6285156272866" id="WhatsApp" target="_blank">
        <i class="fa fa-whatsapp" aria-hidden="true"></i>
    </a>

    @include('landing.layouts.assets.js')
</body>
</html>