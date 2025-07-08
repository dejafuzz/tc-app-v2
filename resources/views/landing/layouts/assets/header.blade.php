<!-- ***** Header Area Start ***** -->
<header class="header-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="menu-area d-flex justify-content-between">
                    <!-- Logo Area  -->
                    <div class="logo-area">
                        <a href="{{ route('home') }}">
                            <img src="landing/img/core-img/logotc.png" alt="Tersimpan Cerita" style="height: 40px;">
                        </a>
                    </div>                    

                    <div class="menu-content-area d-flex align-items-center">
                        <!-- Header Social Area -->
                        <div class="header-social-area d-flex align-items-center">
                            <a href="https://www.instagram.com/tersimpancerita/" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="https://www.tiktok.com/@tersimpancerita" target="_blank" data-toggle="tooltip" data-placement="bottom" title="TikTok">
                                <img src="{{ asset('landing/img/core-img/tiktokicon.png') }}" alt="TikTok" width="18" height="18">
                            </a>
                        </div>
                        <span>
                            <a href="{{ route('login') }}" class="btn login-btn white-btn">Login</a>
                        </span>
                        <!-- Menu Icon -->
                        <span class="navbar-toggler-icon" id="menuIcon"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->