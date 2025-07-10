<?php

namespace App\Http\Controllers\Client;

use App\Helpers\PaymentsHelper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPaketTambahan;
use App\Models\HargaPaket;
use App\Models\PaketTambahan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $booking = Booking::where('user_id',Auth::user()->id)->orderByDesc('created_at')->get();
        $hargaPaket = HargaPaket::orderBy('paket_id')->get();
        $paketTambahan = PaketTambahan::all();

        //PENGECEKAN
        $pesanan = Pesanan::whereHas('booking', function ($query) {
            $query->where('status_booking','Accepted');
        })->get();

        foreach ($pesanan as $pes) {
            $jumlahHargaTambahan = $pes->harga_paket_tambahan;
        
            // foreach ($pes->booking->paketTambahan as $pt) {
            //     $jumlahHargaTambahan += $pt->harga_tambahan;
            // }
        
            $total = $pes->booking->dp + $pes->pelunasan;
            $kekurangan = ($pes->booking->harga_paket->harga + $jumlahHargaTambahan) - ($total + $pes->discount);
        
            // Update pesanan dengan nilai yang telah dihitung
            $pes->update([
                'harga_paket_tambahan' => $jumlahHargaTambahan,
                'kekurangan' => $kekurangan,
                'total' => $total
            ]);
        }
        
        return view('client.booking.index',compact('booking','hargaPaket','paketTambahan'));
    }

    public function store(Request $request)
    {
        $rules = Booking::$rules = [
            'status_booking' => 'nullable',
            'dp' => 'nullable',
            'file_dp' => 'nullable',
            'kota' => 'required',
            'no_wa' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, Booking::$messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $hargaPaket = HargaPaket::find($request->harga_paket_id)->harga;

        
        $b = new Booking();
        $b->id_booking = 'BOOK' . strtoupper(Str::uuid()->toString());
        $b->nama = $request->nama;
        $b->email = $request->email;
        $b->no_wa = $request->no_wa;
        $b->event = $request->event;
        $b->tanggal = $request->tanggal;
        $b->jam = $request->jam;
        $b->kota = $request->kota;
        $b->universitas = $request->universitas;
        $b->fakultas = $request->fakultas;
        $b->lokasi_foto = $request->lokasi_foto;
        $b->ig_mua = $request->ig_mua;
        $b->ig_dress = $request->ig_dress;
        $b->ig_nailart = $request->ig_nailart;
        $b->ig_hijab = $request->ig_hijab;
        $b->ig_dress = $request->ig_dress;
        $b->ig_nailart = $request->ig_nailart;
        $b->ig_hijab = $request->ig_hijab;
        $b->ig_client = $request->ig_client;
        $b->post_foto = $request->post_foto;
        $b->jumlah_anggota = $request->jumlah_anggota;
        $b->req_khusus = $request->req_khusus;
        $b->status_booking = 'Pending';
        $b->harga = $hargaPaket;

        // $b->user_id = Auth::user()->id;
        $b->harga_paket_id = $request->harga_paket_id;
        $b->user_id = Auth::user()->id;

        $idBooking = $b->id_booking;
        $b->save();

        // code untuk paket tambahan
        $book = Booking::find($idBooking);
        // Update paket tambahan jika ada
        if ($request->has('paket_tambahan')) {
            // Hapus semua data pivot terkait
            $book->paketTambahan()->detach();
        
            // Tambahkan kembali data dengan ID kustom
            foreach ($request->paket_tambahan as $paketTambahanId) {
                $book->paketTambahan()->attach($paketTambahanId, [
                    'id_booking_paket_tambahan' => 'BPT' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT),
                ]);
            }
        }
        $book->save();

        return redirect()->back()->with('berhasil','Booking berhasil ditambahkan');
    }

    public function update(Request $request,$id)
    {
        // dd($request->all());
        $request->merge(['dp' => str_replace('.', '', $request->dp)]);
        
        $rules = Booking::$rules = [
            'status_booking' => 'nullable',
            'dp' => 'nullable',
            'file_dp' => 'nullable',
            'kota' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, Booking::$messages);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $harga = HargaPaket::find($request->harga_paket_id)->harga;

        $b = Booking::find($id);
        $b->nama = $request->nama;
        $b->email = $request->email;
        $b->no_wa = $request->no_wa;
        $b->event = $request->event;
        $b->tanggal = $request->tanggal;
        $b->jam = $request->jam;
        $b->kota = $request->kota;
        $b->universitas = $request->universitas;
        $b->fakultas = $request->fakultas;
        $b->lokasi_foto = $request->lokasi_foto;
        $b->ig_mua = $request->ig_mua;
        $b->ig_dress = $request->ig_dress;
        $b->ig_nailart = $request->ig_nailart;
        $b->ig_hijab = $request->ig_hijab;
        $b->ig_client = $request->ig_client;
        $b->post_foto = $request->post_foto;
        $b->jumlah_anggota = $request->jumlah_anggota;
        $b->req_khusus = $request->req_khusus;
        // $b->status_booking = $request->status_booking;
        // $b->user_id = Auth::user()->id;
        $b->harga_paket_id = $request->harga_paket_id;
        $b->harga = $harga;

        // untuk memberi tanggal dibuatnya faktur
        // if ($b->dp != $request->dp || $b->dp == null ) {
        //     $b->tanggal_dp = Carbon::now()->toDate();
        // }
        
        // $b->dp = $request->dp;

        
        // Update paket tambahan jika ada
        if ($request->has('paket_tambahan')) {
            // Hapus semua data pivot terkait
            $b->paketTambahan()->detach();
        
            // Tambahkan kembali data dengan ID kustom
            foreach ($request->paket_tambahan as $paketTambahanId) {
                $b->paketTambahan()->attach($paketTambahanId, [
                    'id_booking_paket_tambahan' => 'BPT' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT),
                ]);
            }
        } else {
            $b->paketTambahan()->detach();
        }
        
        $b->save();

        return redirect()->back()->with('success','Booking berhasil diperbarui');
    }

    public function delete($id)
    {
        $b = Booking::find($id);
        // Hapus file lama jika ada
        if ($b->file_dp) {
            // Menghapus file lama dari storage
            Storage::disk('public')->delete($b->file_dp);
        }
        $b->delete();

        return redirect()->back()->with('success','Booking berhasil dihapus');
    }

    public function ubah_status(Request $request,$id)
    {
        $b = Booking::find($id);
        $b->status_booking = $request->status_booking;
        $b->save();

        return redirect()->back()->with('success','Booking berhasil di Cancel');
    }

    public function dp(Request $request, $id)
    {
        // dd($request->file('file_dp'));
        $request->merge(['dp' => str_replace('.', '', $request->dp)]);
        // dd($request->dp);
        $rules = [
            'dp' => 'nullable|min:0',
            'file_dp' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf',
        ];
        $validator = Validator::make($request->all(), $rules, Booking::$messages);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $b = Booking::find($id);
        // untuk memberi tanggal dibuatnya faktur
        if ($b->dp != $request->dp || $b->dp == null || $b->pelunasan != $request->pelunasan || $b->pelunasan == null) {
            $b->tanggal_dp = Carbon::now()->toDate();
        }
        
        if ($request->jenis_pembayaran == 'DP') {
            $b->dp = $request->nominal;
            
            // Cek jika file ada di request
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Hapus file lama jika ada
                if ($b->file_dp) {
                    // Menghapus file lama dari storage
                    Storage::disk('public')->delete($b->file_dp);
                }

                $path = 'uploads/dp';

                // Simpan file baru
                $b->file_dp = $file->store($path, 'public');

            }
        } elseif ($request->jenis_pembayaran == 'Pelunasan') {
            $b->pelunasan = $request->nominal;

            // Cek jika file ada di request
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Hapus file lama jika ada
                if ($b->file_pelunasan) {
                    // Menghapus file lama dari storage
                    Storage::disk('public')->delete($b->file_pelunasan);
                }

                $path = 'uploads/pelunasan';

                // Simpan file baru
                $b->file_pelunasan = $file->store($path, 'public');
            }
        }

        
        $b->save();

        return redirect()->back()->with('success', 'DP berhasil ditambahkan');
    }

    public function add_pelunasan(Request $request,$id)
    {
        $request->merge(['pelunasan' => str_replace('.', '', $request->pelunasan)]);
        // dd($request->pelunasan);

        $pesanan = Pesanan::where('booking_id',$id)->first();

        $pesanan->pelunasan = $request->pelunasan;
        
        if ($request->hasFile('file_pelunasan')) {
            $file = $request->file('file_pelunasan');

            // Hapus file lama jika ada
            if ($pesanan->file_pelunasan) {
                // Menghapus file lama dari storage
                Storage::disk('public')->delete($pesanan->file_pelunasan);
            }

            $path = 'uploads/pelunasan';

            // Simpan file baru
            $pesanan->file_pelunasan = $file->store($path, 'public');
        }
        $pesanan->save();

        return redirect()->back()->with('success','Pelunasan sedang diverifikasi oleh Admin');
    }


    

    public function pembayaran(Request $request, $id)
    {
        // return 'ads';
        $request->validate(
            [
                'nominal' => 'nullable|min:0',
                'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf',
                'jenis_pembayaran' => 'required',
            ],
            [
                'file.required' => 'Bukti Pembayaran wajib diisi.',
                'jenis_pembayaran.required' => 'Jenis Pembayaran wajib diisi.',
            ]
        );

        $cekPesanan = Booking::find($id);

        if ($request->jenis_pembayaran == 'DP') {
            PaymentsHelper::helperDp($request, $id);
        } elseif ($request->jenis_pembayaran == 'Pelunasan' && $cekPesanan->pesanan) {
            PaymentsHelper::helperPelunasan($request, $id);
        } elseif ($request->jenis_pembayaran == 'Pelunasan' && !$cekPesanan->pesanan) {
            PaymentsHelper::helperDp($request, $id);
        }

        return redirect()->back()->with('success','Pembayaran sedang diverifikasi oleh Admin');
    }
}