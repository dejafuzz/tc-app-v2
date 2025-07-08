
@extends('landing.layouts.master')
@section('content')
<!-- ***** Hero Area Start ***** -->
<section class="hero-area">
    <div class="hero-slides owl-carousel">
        @foreach ($foto as $item)
            <!-- Single Hero Slide -->
            <div class="single-hero-slide bg-img slide-background-overlay" style="background-image: url({{ asset('storage/' . $item->foto) }});">
                <div class="container h-100">
                    <div class="row h-100 align-items-end">
                        <div class="col-12">
                            <div class="hero-slides-content">
                                <div class="line"></div>
                                <h2>{{ $item->univ }}</h2>
                                <p>{{ $item->keterangan }}.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
<!-- ***** Hero Area End ***** -->

<!-- ***** Portfolio Area Start ***** -->
<div class="portfolio-area section-padding-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="portfolio-title">
                    <h2>“Make your aesthetic moment with us.”</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-between">
            <!-- Single Portfoio Area -->
            <div class="col-12 col-md-6">
                <div class="single-portfolio-item mt-100 portfolio-item-1 wow fadeIn">
                    <div class="backend-content">
                        
                    </div>
                    <div class="portfolio-thumb">
                        <img src="landing/img/bg-img/s1.jpg" alt="">
                    </div>
                    {{-- <div class="portfolio-meta">
                        <p class="portfolio-date">Sep 06, 2024</p>
                        <h2>Graduation Group photoshoot</h2>
                    </div> --}}
                </div>
            </div>
            <!-- Single Portfoio Area -->
            <div class="col-12 col-md-6">
                <div class="single-portfolio-item mt-230 portfolio-item-2 wow fadeIn">
                    <div class="backend-content">
                        
                    </div>
                    <div class="portfolio-thumb">
                        <img src="landing/img/bg-img/s2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Single Portfoio Area -->
            <div class="col-12 col-md-6">
                <div class="single-portfolio-item mt-100 portfolio-item-3 wow fadeIn">
                    <div class="backend-content">
                        
                    </div>
                    <div class="portfolio-thumb">
                        <img src="landing/img/bg-img/s3.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-end">
            <!-- Single Portfoio Area -->
            <div class="col-12 col-md-6">
                <div class="single-portfolio-item portfolio-item-4 wow fadeIn">
                    <div class="backend-content">
                        
                    </div>
                    <div class="portfolio-thumb">
                        <img src="landing/img/bg-img/s4.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Single Portfoio Area -->
            <div class="col-12 col-md-6">
                <div class="single-portfolio-item portfolio-item-5 wow fadeIn">
                    <div class="backend-content">
                        
                    </div>
                    <div class="portfolio-thumb">
                        <img src="landing/img/bg-img/s5.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-end">
            <!-- Single Portfoio Area -->
            <div class="col-12 col-md-6">
                <div class="single-portfolio-item portfolio-item-7 wow fadeIn">
                    <div class="backend-content">
                        
                        {{-- <h2>Future</h2> --}}
                    </div>
                    <div class="portfolio-thumb">
                        <img src="landing/img/bg-img/s6.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Portfolio Area End ***** -->

<!-- ***** Call to Action Area Start ***** -->
<div class="sonar-call-to-action-area section-padding-0-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="call-to-action-content wow fadeInUp" data-wow-delay="0.5s">
                    <h2>We are experienced photographer</h2>
                    <h2>Let’s fast book now</h2>
                    <a href="{{ route('fastbooking') }}" class="btn sonar-btn mt-100">Book Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Call to Action Area End ***** -->
@endsection