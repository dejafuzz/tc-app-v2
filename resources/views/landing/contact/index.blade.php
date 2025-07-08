@extends('landing.layouts.master')
@section('content')

    <!-- ***** Hero Area Start ***** -->
    <div class="hero-area d-flex align-items-center">
        <!-- Hero Thumbnail -->
        <div class="hero-thumbnail equalize bg-img" style="background-image: url(landing/img/bg-img/contact-us.jpg);"></div>
        
        <!-- Hero Content -->
        <div class="hero-content equalize">
            <div class="container-fluid h-100">
                <div class="row h-100 align-items-center justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="line"></div>
                        <h2>Get in Touch with Us!</h2>
                        <p>Have questions or need more information? Contact us now! We're here to help you capture your special graduation moments.</p>
                        <a href="https://api.whatsapp.com/send/?phone=6285156272866&text&type=phone_number&app_absent=0" target="_blank" class="btn sonar-btn white-btn">contact me</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Hero Area End ***** -->

    <section class="sonar-contact-area section-padding-100">
        <!-- back end content -->
        <div class="backEnd-content">
            <img class="dots" src="img/core-img/dots.png" alt="">
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-12 contact-form">
                    <h2 class="text-center mb-5">Share your feedback to help us do better</h2>
                </div>
        
                <!-- Testimoni di kiri -->
                <div class="col-12 col-lg-7">
                    <div class="sonar-testimonials-area bg-img" style="margin: 0; background-image: url(img/bg-img/tes.jpg);">
                        <div class="container-fluid">
                            <div class="testimonial-content bg-white">
                                <div class="section-heading text-left">
                            <div class="line"></div>
                            <h2>Testimonials</h2>
                        </div>
        
                        <div class="testimonial-slides owl-carousel">
                            @php
                                $testimoni = App\Models\Testimoni::where('status', 'Posted')->get();
                            @endphp
                            @foreach ($testimoni as $item)
                                <div class="single-tes-slide">
                                    <p style="color: black">{{ $item->deskripsi }}</p>
                                    <h6>{{ $item->nama }}, {{ $item->event }}</h6>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                    </div>
                </div>
        
                <!-- Form di kanan -->
                <div class="col-12 col-lg-5 contact-form mt-100">
                    <form action="{{ route('store.testi') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nama" placeholder="Your Name" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="event" placeholder="Your Event" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control" name="deskripsi" rows="5" placeholder="Description" required></textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn sonar-btn">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
        

        {{-- <div class="sonar-testimonials-area bg-img" style="background-image: url(img/bg-img/tes.jpg);">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-10 col-lg-7">
                        <div class="testimonial-content bg-white">
                            <div class="section-heading text-left">
                                <div class="line"></div>
                                <h2>Testimonials</h2>
                            </div>
    
                            <div class="testimonial-slides owl-carousel">
    
                                @php
                                    $testimoni = App\Models\Testimoni::where('status', 'Posted')->get();
                                @endphp
                                @foreach ($testimoni as $item)
                                    <div class="sin gle-tes-slide">
                                        <p style="color: black">{{ $item->deskripsi }}</p>
                                        <h6>{{ $item->nama }}, {{ $item->event }}</h6>
                                    </div>
                                @endforeach
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </section>

    <!-- ***** Call to Action Area Start ***** -->
    <div class="sonar-call-to-action-area bg-gray section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="call-to-action-content">
                        <h2>We are experienced photographer</h2>
                        <h2>Let’s fast booking now</h2>
                        <a href="{{ route('fastbooking') }}" class="btn sonar-btn mt-100">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Call to Action Area End ***** -->

    <!-- Google Maps -->
    {{-- <div class="map-area">
        <div id="googleMap" class="googleMap"></div>
    </div> --}}


    <!-- Contact Form Area -->

                {{-- code old --}}
                {{-- <div class="col-12">
                    <div class="contact-form text-center">

                        <h2>I am an experienced photographer</h2>
                        <h4>Let’s talk</h4>

                        <form id="contactForm">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="contact-name" placeholder="Your Name" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="contact-email" placeholder="Your Email" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="contact-subject" placeholder="Subject" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="message" cols="30" rows="5" placeholder="Message" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn sonar-btn" id="sendMessage">Contact Me</button>
                                </div>
                            </div>
                        </form>
                        
                        <script>
                            document.getElementById('sendMessage').addEventListener('click', function () {
                                // Ambil nilai dari input
                                const name = document.getElementById('contact-name').value;
                                const email = document.getElementById('contact-email').value;
                                const subject = document.getElementById('contact-subject').value;
                                const message = document.getElementById('message').value;
                        
                                // Validasi input
                                if (!name || !email || !subject || !message) {
                                    alert('Please fill in all fields.');
                                    return;
                                }
                        
                                // Format pesan WhatsApp
                                const whatsappMessage = `Hello, I would like to inquire:\n\n` +
                                                        `*Name:* ${name}\n` +
                                                        `*Email:* ${email}\n` +
                                                        `*Subject:* ${subject}\n` +
                                                        `*Message:* ${message}\n\n` +
                                                        `Thank you!`;
                        
                                // Encode pesan untuk URL
                                const encodedMessage = encodeURIComponent(whatsappMessage);
                        
                                // Nomor tujuan WhatsApp
                                const whatsappNumber = '6285156272866';
                        
                                // Buat URL WhatsApp
                                const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;
                        
                                // Redirect ke WhatsApp
                                window.open(whatsappUrl, '_blank');
                            });
                        </script>
                        
                    </div>
                </div> --}}
@endsection
