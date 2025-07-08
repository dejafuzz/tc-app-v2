<?php

use App\Http\Controllers\auth\AuthController;

//LANDING
use App\Http\Controllers\Landing\HomeController;
use App\Http\Controllers\Landing\AboutUsController;
use App\Http\Controllers\Landing\PackagesController;
use App\Http\Controllers\Landing\PortofolioController;
use App\Http\Controllers\Landing\ContactController;
use App\Http\Controllers\Landing\FastBookingController;

//ADMIN
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\FotograferController;
use App\Http\Controllers\Admin\KategoriPaketController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\WilayahController;
use App\Http\Controllers\Admin\PaketTambahanController;
use App\Http\Controllers\Admin\HargaPaketController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\FotoController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
//CLIENT
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\FotoController as ClientFotoController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

use App\Exports\PesananExport;
use App\Http\Controllers\Admin\FotoLandingController;
use App\Http\Controllers\Admin\PaketLandingController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\TestimoniController;
use App\Http\Controllers\Client\TestimoniController as ClientTestimoniController;
use Maatwebsite\Excel\Facades\Excel;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('landing.landing');
// });

// Route::get('/', [AdminDashboardController::class, 'landing'])->name('landing');



Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/register', [AuthController::class,'register'])->name('register');
Route::post('/action-register', [AuthController::class,'action_register'])->name('action.register');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// FORGOT PASSWORD
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// LANDING
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('/packages', [PackagesController::class, 'index'])->name('packages');
Route::get('/portofolio', [PortofolioController::class, 'index'])->name('portofolio');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::get('/fastbooking', [FastBookingController::class, 'index'])->name('fastbooking');
Route::post('/store-fastbooking', [FastBookingController::class, 'store'])->name('store.fastbooking');

Route::middleware(['auth'])->group(function () {

    //ADMIN
    Route::prefix('admin')->name('admin.')->middleware('CekUserLogin:1')->group(function () {
        //DASHBOARD
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        //FOTO HOME
        Route::get('foto-home', [FotoLandingController::class, 'index'])->name('foto.landing');
        Route::post('foto-home/store', [FotoLandingController::class, 'store'])->name('store.foto.landing');
        Route::put('foto-home/update/{id}', [FotoLandingController::class, 'update'])->name('update.foto.landing');
        Route::delete('foto-home/delete/{id}', [FotoLandingController::class, 'delete'])->name('delete.foto.landing');
        
        //ROLES
        Route::get('roles', [RolesController::class, 'index'])->name('roles');
        
        //USERS
        Route::get('users', [UsersController::class, 'index'])->name('users');
        Route::post('store/users', [UsersController::class, 'store'])->name('store.users');
        Route::put('update/users/{id}', [UsersController::class, 'update'])->name('update.users');
        Route::delete('delete/users/{id}', [UsersController::class, 'delete'])->name('delete.users');
        
        //FOTOGRAFER
        Route::get('fotografer', [FotograferController::class, 'index'])->name('fotografer');
        Route::post('store/fotografer', [FotograferController::class, 'store'])->name('store.fotografer');
        Route::put('update/fotografer/{id}', [FotograferController::class, 'update'])->name('update.fotografer');
        Route::delete('delete/fotografer/{id}', [FotograferController::class, 'delete'])->name('delete.fotografer');
        
        //WILAYAH
        Route::get('wilayah', [WilayahController::class, 'index'])->name('wilayah');
        Route::post('store/wilayah', [WilayahController::class, 'store'])->name('store.wilayah');
        Route::put('update/wilayah/{id}', [WilayahController::class, 'update'])->name('update.wilayah');
        Route::delete('delete/wilayah/{id}', [WilayahController::class, 'delete'])->name('delete.wilayah');
        
        //KATEGORI PAKET
        Route::get('kategori-paket', [KategoriPaketController::class, 'index'])->name('kategori-paket');
        Route::post('store/kategori-paket', [KategoriPaketController::class, 'store'])->name('store.kategori-paket');
        Route::put('update/kategori-paket/{id}', [KategoriPaketController::class, 'update'])->name('update.kategori-paket');
        Route::delete('delete/kategori-paket/{id}', [KategoriPaketController::class, 'delete'])->name('delete.kategori-paket');
        
        //PAKET
        Route::get('paket', [PaketController::class, 'index'])->name('paket');
        Route::post('store/paket', [PaketController::class, 'store'])->name('store.paket');
        Route::put('update/paket/{id}', [PaketController::class, 'update'])->name('update.paket');
        Route::delete('delete/paket/{id}', [PaketController::class, 'delete'])->name('delete.paket');
        
        //HARGA PAKET
        Route::get('harga-paket', [HargaPaketController::class, 'index'])->name('harga-paket');
        Route::post('store/harga-paket', [HargaPaketController::class, 'store'])->name('store.harga-paket');
        Route::put('update/harga-paket/{id}', [HargaPaketController::class, 'update'])->name('update.harga-paket');
        Route::delete('delete/harga-paket/{id}', [HargaPaketController::class, 'delete'])->name('delete.harga-paket');
        
        //PAKET TAMBAHAN
        Route::get('paket-tambahan', [PaketTambahanController::class, 'index'])->name('paket-tambahan');
        Route::post('store/paket-tambahan', [PaketTambahanController::class, 'store'])->name('store.paket-tambahan');
        Route::put('update/paket-tambahan/{id}', [PaketTambahanController::class, 'update'])->name('update.paket-tambahan');
        Route::delete('delete/paket-tambahan/{id}', [PaketTambahanController::class, 'delete'])->name('delete.paket-tambahan');
        
        //BOOKING
        Route::get('booking', [BookingController::class, 'index'])->name('booking');
        Route::post('store/booking', [BookingController::class, 'store'])->name('store.booking');
        Route::put('update/booking/{id}', [BookingController::class, 'update'])->name('update.booking');
        Route::put('update/dpbooking/{id}', [BookingController::class, 'updateDp'])->name('update.dpbooking');
        Route::delete('delete/booking/{id}', [BookingController::class, 'delete'])->name('delete.booking');
        Route::put('update-status/booking/{id}', [BookingController::class, 'ubah_status'])->name('ubah.status.booking');
        
        //PESANAN
        Route::get('pesanan', [PesananController::class, 'index'])->name('pesanan');
        Route::get('filter/pesanan', [PesananController::class, 'filter'])->name('filter.pesanan');
        Route::put('update/pesanan/{id}', [PesananController::class, 'update'])->name('update.pesanan');
        Route::delete('delete/pesanan/{id}', [PesananController::class, 'delete'])->name('delete.pesanan');

        // PELUNASAN
        Route::put('pelunasan/{id}', [PesananController::class, 'add_pelunasan'])->name('add.pelunasan');

        //FOTO
        Route::get('foto', [FotoController::class, 'index'])->name('foto');
        Route::put('update/foto/{id}', [FotoController::class, 'update'])->name('update.foto');
        Route::delete('delete/foto/{id}', [FotoController::class, 'delete'])->name('delete.foto');
        
        //PAKET LANDING
        Route::get('paket-landing', [PaketLandingController::class, 'index'])->name('paket.landing');
        Route::post('paket-landing/store', [PaketLandingController::class, 'store'])->name('store.paket.landing');
        Route::put('paket-landing/update/{id}', [PaketLandingController::class, 'update'])->name('update.paket.landing');
        Route::delete('paket-landing/delete/{id}', [PaketLandingController::class, 'delete'])->name('delete.paket.landing');

        //EXPORT PESANAN
        Route::get('/export-pesanan', [PesananController::class, 'export'])->name('export.pesanan');

        //EXPORT PENGELUARAN
        Route::get('/export-pengeluaran', [PengeluaranController::class, 'export'])->name('export.pengeluaran');

        //EXPORT FAKTUR
        Route::get('/export-faktur/{id}', [PesananController::class, 'faktur'])->name('export.faktur');


        //TESTIMONI
        Route::get('testimoni', [TestimoniController::class, 'index'])->name('testi');
        Route::post('testimoni/store', [TestimoniController::class, 'store'])->name('store.testi');
        Route::put('testimoni/update/{id}', [TestimoniController::class, 'update'])->name('update.testi');
        Route::delete('testimoni/delete/{id}', [TestimoniController::class, 'delete'])->name('delete.testi');

        //JENIS PENGELUARAN
        Route::get('jenis-pengeluaran', [PengeluaranController::class, 'jenisPengeluaran'])->name('jenispengeluaran');
        Route::post('store/jenis-pengeluaran', [PengeluaranController::class, 'storeJenisPengeluaran'])->name('store.jenispengeluaran');
        Route::put('update/jenis-pengeluaran/{id}', [PengeluaranController::class, 'updateJenisPengeluaran'])->name('update.jenispengeluaran');
        Route::delete('delete/jenis-pengeluaran/{id}', [PengeluaranController::class, 'deleteJenisPengeluaran'])->name('delete.jenispengeluaran');
        
        //PENGELUARAN
        Route::get('pengeluaran', [PengeluaranController::class, 'pengeluaran'])->name('pengeluaran');
        Route::get('pengeluaran/filter', [PengeluaranController::class, 'filter'])->name('pengeluaran.filter');

        Route::post('store/pengeluaran', [PengeluaranController::class, 'storePengeluaran'])->name('store.pengeluaran');
        Route::put('update/pengeluaran/{id}', [PengeluaranController::class, 'updatePengeluaran'])->name('update.pengeluaran');
        Route::delete('delete/pengeluaran/{id}', [PengeluaranController::class, 'deletePengeluaran'])->name('delete.pengeluaran');
    });
    
    //PROFILE
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('update/profile', [ProfileController::class, 'update'])->name('profile.update');

    //CLIENT
    Route::prefix('client')->name('client.')->middleware('CekUserLogin:2')->group(function () {
        //DASHBOARD
        Route::get('dashboard', [ClientDashboardController::class, 'dashboard_client'])->name('dashboard');

        // BOOKING
        Route::get('booking', [ClientBookingController::class, 'index'])->name('booking');
        Route::post('store/booking', [ClientBookingController::class, 'store'])->name('store.booking');
        Route::put('update/booking/{id}', [ClientBookingController::class, 'update'])->name('update.booking');
        Route::delete('delete/booking/{id}', [ClientBookingController::class, 'delete'])->name('delete.booking');
        Route::put('ubah-status/booking/{id}', [ClientBookingController::class, 'ubah_status'])->name('ubah.status.booking');
        // DP
        Route::put('dp/{id}', [ClientBookingController::class, 'dp'])->name('add.dp');
        Route::put('pembayaran/{id}', [ClientBookingController::class, 'pembayaran'])->name('add.pembayaran');
        // PELUNASAN
        Route::put('pelunasan/{id}', [ClientBookingController::class, 'add_pelunasan'])->name('add.pelunasan');

        Route::get('/export-faktur/{id}', [PesananController::class, 'faktur'])->name('export.faktur');

        // FOTO
        Route::put('list/foto/{id}', [ClientFotoController::class, 'add_list_foto'])->name('add.list.foto');

        //TESTIMONI
        Route::get('testimoni', [ClientTestimoniController::class, 'index'])->name('testi');
    });
    
    
});

Route::post('testimoni/store', [ClientTestimoniController::class, 'store'])->name('store.testi');