<!-- ***** Main Menu Area Start ***** -->
<div class="mainMenu d-flex align-items-center justify-content-between">
    <!-- Close Icon -->
    <div class="closeIcon">
        <i class="ti-close" aria-hidden="true"></i>
    </div>
    <!-- Logo Area -->
    <div class="logo-area">
        <a href="{{ route('home') }}">
            <img src="landing/img/core-img/logotc.png" alt="Tersimpan Cerita" style="height: 40px;">
        </a>
    </div>  
    <!-- Nav -->
    <div class="sonarNav fadeInUp" data-wow-delay="1s">
        <nav>
            <ul>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about-us') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('packages') }}">Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portofolio') }}">Portofolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('fastbooking') }}">Fast Booking</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Copwrite Text -->
    <div class="copywrite-text">
        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <a href="#" target="_blank">Tersimpan Cerita</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
    </div>
</div>
<!-- ***** Main Menu Area End ***** -->