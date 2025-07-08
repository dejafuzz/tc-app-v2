@extends('landing.layouts.master')
@section('content')

    <!-- ***** Hero Area Start ***** -->
    <div class="hero-area d-flex align-items-center">
        <!-- Hero Thumbnail -->
        <div class="hero-thumbnail equalize bg-img" style="background-image: url(landing/img/home-sample/ui.jpg);"></div>
        
        <!-- Hero Content -->
        <div class="hero-content equalize">
            <div class="container-fluid h-100">
                <div class="row h-100 align-items-center justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="line"></div>
                        <h2>Take a look our Portofolio</h2>
                        <p>Discover our collection of stunning graduation photos. We take pride in capturing unforgettable moments with high-quality and artistic shots.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Portfolio Menu -->
        {{-- <div class="sonar-portfolio-menu">
            <div class="text-center portfolio-menu">
                <button class="btn active" data-filter="*">All</button>
                <button class="btn" data-filter=".landscapes">UGM</button>
                <button class="btn" data-filter=".portraits">UI</button>
                <button class="btn" data-filter=".fashion">UNSOED</button>
                <button class="btn" data-filter=".studio">UII</button>
            </div>
        </div> --}}
    </div>
    <!-- ***** Hero Area End ***** -->

    
    <!-- ****** Gallery Area Start ****** -->
    <section class="sonar-projects-area" id="projects">
        <script src="https://static.elfsight.com/platform/platform.js" async></script>
        <div class="elfsight-app-80c288a9-8f4d-4e2d-a584-74944b0bd54e" data-elfsight-app-lazy></div>
        <div class="container-fluid">
            
            
            <div class="row">
                <div class="col-12 text-center">
                    <a href="https://www.instagram.com/tersimpancerita" target="_blank" class="btn sonar-btn">Load More</a>
                </div>
            </div>
        </div>
    </section>
    <!-- ****** Gallery Area End ****** -->

    <script>
        window.addEventListener('load', function() {
            const elfsightContainer = document.querySelector('.elfsight-app-80c288a9-8f4d-4e2d-a584-74944b0bd54e');
            if (elfsightContainer) {
                elfsightContainer.style.minHeight = '999px';
            }
        });
    </script>
    
@endsection

{{-- <div class="row sonar-portfolio">
                
                
    <!-- Single gallery Item -->
    <div class="col-12 col-sm-12 col-lg-21 single_gallery_item landscapes studio wow fadeInUpBig" data-wow-delay="300ms">
        <a class="gallery-img" href="landing/img/portfolio-img/1.jpg"><img src="landing/img/portfolio-img/1.jpg" alt=""></a>
        <!-- Gallery Content -->
        <div class="gallery-content">
            <h4>Mountains in the mist</h4>
            <p>Landscapes</p>
        </div>
    </div>
</div> --}}