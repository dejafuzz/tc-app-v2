<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <img src="{{ asset('landing/img/core-img/logotc.png') }}" alt="Tersimpan Cerita" class="sidebar-brand-text mx-3" style="height: 40px;">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @if (Auth::user()->role_id == 1)
    <li class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        PEMESANAN
    </div>
    
    <li class="nav-item {{ Request::routeIs('admin.booking') || Request::routeIs('admin.booking.accepted') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="{{ Request::routeIs('admin.booking') || Request::routeIs('admin.booking.accepted') ? 'true' : 'false' }}" 
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Booking</span>
        </a>
        <div id="collapseTwo" class="collapse {{ Request::routeIs('admin.booking') || Request::routeIs('admin.booking.accepted') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::routeIs('admin.booking') ? 'active' : '' }}" href="{{ route('admin.booking') }}">Booking</a>
                <a class="collapse-item {{ Request::routeIs('admin.booking.accepted') ? 'active' : '' }}" href="{{ route('admin.booking.accepted') }}">Booking Accepted</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ Request::routeIs('admin.pesanan') || Request::routeIs('admin.pesanan.complete') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="{{ Request::routeIs('admin.pesanan') || Request::routeIs('admin.pesanan.complete') ? 'true' : 'false' }}" 
            aria-controls="collapseOne">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Pesanan</span>
        </a>
        <div id="collapseOne" class="collapse {{ Request::routeIs('admin.pesanan') || Request::routeIs('admin.pesanan.complete') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::routeIs('admin.pesanan') ? 'active' : '' }}" href="{{ route('admin.pesanan') }}">Pesanan</a>
                <a class="collapse-item {{ Request::routeIs('admin.pesanan.complete') ? 'active' : '' }}" href="{{ route('admin.pesanan.complete') }}">Pesanan Complete</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ Request::routeIs('admin.foto') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.foto') }}">
            <i class="fas fa-fw fa-camera-retro"></i>
            <span>Foto</span>
        </a>
    </li>
    
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        PENGELUARAN
    </div>
    <li class="nav-item {{ Request::routeIs('admin.jenispengeluaran') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.jenispengeluaran') }}">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Jenis Pengeluaran</span>
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.pengeluaran') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pengeluaran') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Pengeluaran</span>
        </a>
    </li>
    
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        PAKET
    </div>
    <li class="nav-item {{ Request::routeIs('admin.wilayah') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.wilayah') }}">
            <i class="fas fa-fw fa-location-arrow"></i>
            <span>Wilayah</span>
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.kategori-paket') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.kategori-paket') }}">
            <i class="fas fa-fw fa-pen"></i>
            <span>Kategori</span>
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.paket') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.paket') }}">
            <i class="fas fa-fw fa-gift"></i>
            <span>Paket</span>
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.harga-paket') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.harga-paket') }}">
            <i class="fas fa-fw fa-coins"></i>
            <span>Harga Paket</span>
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.paket-tambahan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.paket-tambahan') }}">
            <i class="fas fa-fw fa-gifts"></i>
            <span>Paket Tambahan</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Master
    </div>
    <li class="nav-item {{ Request::routeIs('admin.roles') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.roles') }}">
            <i class="fas fa-fw fa-crown"></i>
            <span>Roles</span>
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.users') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span>
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.fotografer') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.fotografer') }}">
            <i class="fas fa-fw fa-camera"></i>
            <span>Fotografer</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        LANDINGPAGE
    </div>
    <li class="nav-item {{ Request::routeIs('admin.foto.landing') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.foto.landing') }}">
            <i class="fas fa-fw fa-image"></i>
            <span>Foto Landing</span>
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.testi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.testi') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Testimoni</span>
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.paketlanding') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.paket.landing') }}">
            <i class="fas fa-fw fa-gift"></i>
            <span>Paket Landing</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    @endif

    @if (Auth::user()->role_id == 2)

    <li class="nav-item {{ Request::routeIs('client.booking') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('client.booking') }}">
            <i class="fas fa-fw fa-location-arrow"></i>
            <span>Booking</span>
        </a>
    </li>

    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link btn logout-btn">
                <i class="fas fa-sign-out-alt fa-sm fa-fw text-gray-400"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
    


    <hr class="sidebar-divider d-none d-md-block">
    @endif

    <script>
        // Pilih semua tombol dengan kelas delete-btn
        document.querySelectorAll('.logout-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah pengiriman form langsung
    
                const form = this.closest('form'); // Ambil form terdekat dari tombol yang diklik
    
                Swal.fire({
                    title: 'Apakah anda ingin logout?',
                    // text: "Ya,!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Kirim form jika pengguna mengonfirmasi
                    }
                });
            });
        });
    </script>
</ul>

<script>
    function toggleSidebarOnResize() {
        const sidebar = document.getElementById('accordionSidebar');
        if (window.innerWidth < 768) {
            sidebar.classList.add('toggled');
        } else {
            sidebar.classList.remove('toggled');
        }
    }

    document.addEventListener('DOMContentLoaded', toggleSidebarOnResize);
    window.addEventListener('resize', toggleSidebarOnResize);
</script>