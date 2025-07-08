<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Foto;
use App\Models\Paket;
use App\Models\Pesanan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        $complete = Pesanan::where('status_pembayaran', 'Lunas')->count();
        $editing = Foto::where('status_foto', 'Editing')->count();
        $pending = Booking::where('status_booking', 'Pending')->count();
        // dd($complete);
        

        // Total per bulan untuk tahun berjalan (misal 2025)
        $monthlyTotals = DB::table('pesanan')
                    ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
                    ->whereYear('created_at', now()->year)
                    ->where('status_pembayaran', 'Lunas')
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->pluck('total', 'month');

        // Pastikan urutan bulan tetap 1–12, walau tidak semua bulan ada data
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
        $monthlyData[] = $monthlyTotals[$i] ?? 0;
        }

        // Total per tahun
        $yearTotals = DB::table('pesanan')
                    ->selectRaw('YEAR(created_at) as year, SUM(total) as total')
                    ->where('status_pembayaran', 'Lunas')
                    ->groupBy(DB::raw('YEAR(created_at)'))
                    ->orderBy('year')
                    ->pluck('total', 'year');

        // Siapkan array tahun dan total
        $yearLabels = $yearTotals->keys()->toArray();
        $yearData = $yearTotals->values()->toArray();

        return view ('admin.dashboard.index',compact('monthlyData', 'yearLabels', 'yearData', 'complete', 'editing', 'pending'));
    }

    public function landing()
    {
        $paket = Paket::all();
        $wilayah1 = Wilayah::where('kode','W1')->get();
        $wilayah2 = Wilayah::where('kode','W2')->get();
        // dd($paket->kategori_paket);
        return view('landing.landing',compact('paket','wilayah1','wilayah2'));
    }
}