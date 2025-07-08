<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Foto;
use App\Models\Fotografer;
use App\Models\HargaPaket;
use App\Models\Pesanan;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Exports\PesananExport;
use App\Models\PaketTambahan;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    public function index(){

        $bulan = request()->get('bulan');
        $hargaPaket = HargaPaket::orderBy('paket_id')->get();

        $pesanan = Pesanan::with('booking')
                    ->whereHas('booking', function ($query) use ($bulan) {
                        $query->where('status_booking', 'Accepted');

                        if ($bulan) {
                            $query->whereYear('tanggal', date('Y', strtotime($bulan)))
                                ->whereMonth('tanggal', date('m', strtotime($bulan)));
                        }
                    })
                    ->join('booking', 'pesanan.booking_id', '=', 'booking.id_booking')
                    ->leftJoin('foto', 'pesanan.id_pesanan', '=', 'foto.pesanan_id') // join ke tabel foto
                    ->orderByRaw("CASE WHEN foto.status_foto = 'Complete' THEN 1 ELSE 0 END") // Completed di bawah
                    ->orderBy('booking.tanggal', 'asc') // urut tanggal naik
                    ->select('pesanan.*')
                    ->get();
        
        

        // dd($pesanan);
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
        
        $fotografer = Fotografer::all();
        $paketTambahan = PaketTambahan::all();
        
        return view('admin.pesanan.index',compact('pesanan','fotografer','hargaPaket','paketTambahan'));
    }

    public function filter2(Request $request)
    {
        $bulan = $request->get('bulan');
        
        if ($bulan) {
            $pesanan = Pesanan::with(['booking', 'fotografer'])
                ->whereHas('booking', function ($query) use ($bulan) {
                    $query->whereMonth('tanggal', '=', \Carbon\Carbon::parse($bulan)->month)
                        ->whereYear('tanggal', '=', \Carbon\Carbon::parse($bulan)->year)
                        ->where('status_booking', 'Accepted');
                })
                ->get();
        } else {
            $pesanan = Pesanan::with(['booking', 'fotografer'])
                ->whereHas('booking', function ($query) use ($bulan) {
                    $query->where('status_booking', 'Accepted');
                })
                ->get();
        }

        $filteredData = $pesanan->map(function ($item) {
            return [
                'tanggal' => \Carbon\Carbon::parse($item->booking->tanggal)->translatedFormat('d F Y') ?? '-',
                'negara' => $item->booking->negara ?? 'Indonesia',
                'kota' => $item->booking->kota ?? '-',
                'universitas' => $item->booking->universitas ?? '-',
                'nama' => $item->booking->nama ?? '-',
                'waktu' => $item->booking->jam . '-' . $item->booking->jam_selesai ?? '-',
                'paket' => $item->booking->harga_paket->paket->kategori_paket->nama_kategori . ' ' . $item->booking->harga_paket->paket->nama_paket,
                'fg' => $item->fotografer->nama ?? '-',
                'fakultas' => $item->booking->fakultas ?? '-',
                'lokasi_foto' => $item->booking->lokasi_foto ?? '-',
                'upload_ig' => $item->booking->post_foto ?? '-',
                'keterangan' => $item->keterangan ?? '-',
                'status_foto' => $item->foto->status_foto ?? '-',
                'harga' => 'Rp ' . number_format($item->booking->harga_paket->harga, 0, ',', '.'),
                'total_paket_tambahan' => 'Rp ' . number_format($item->harga_paket_tambahan, 0, ',', '.'),
                'dp' => 'Rp ' . number_format($item->booking->dp, 0, ',', '.'),
                'kekurangan' => 'Rp ' . number_format($item->kekurangan, 0, ',', '.'),
                'pelunasan' => 'Rp ' . number_format($item->pelunasan, 0, ',', '.'),
                'total' => 'Rp ' . number_format($item->total, 0, ',', '.'),
                'freelance' => 'Rp ' . number_format($item->freelance, 0, ',', '.'),
                'nomor_wa' => $item->booking->no_wa ?? '-',
                'aksi' => view('admin.pesanan.index', compact('item'))->render(),
            ];
        });

        return response()->json($filteredData);
    }

    public function filter(Request $request)
    {
        $bulan = $request->get('bulan');
        $pesanan = Pesanan::whereHas('booking', function ($query) use ($bulan) {
                $query->where('status_booking', 'Accepted');
                if ($bulan) {
                    $query->whereMonth('tanggal', '=', \Carbon\Carbon::parse($bulan)->month)
                        ->whereYear('tanggal', '=', \Carbon\Carbon::parse($bulan)->year);
                }
            })->get();

    return view('admin.pesanan.index', compact('pesanan'));
    }

    public function update(Request $request,$id)
    {
        $request->merge(
            [
                    'harga' => str_replace('.', '', $request->harga),
                    'harga_paket_tambahan' => str_replace('.', '', $request->harga_paket_tambahan),
                    'dp' => str_replace('.', '', $request->dp),
                    'kekurangan' => str_replace('.', '', $request->kekurangan),
                    'pelunasan' => str_replace('.', '', $request->pelunasan),
                    'discount' => str_replace('.', '', $request->discount),
                    'total' => str_replace('.', '', $request->total),
                    'freelance' => str_replace('.', '', $request->freelance),
                ]
        );

        $rules = [
            'tanggal' => 'required|date',
            'negara' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'universitas' => 'nullable|string|max:255',
            'nama' => 'required|string|max:255',
            'jam' => 'required',
            // 'kategori_paket' => 'required|string|max:255',
            'fotografer' => 'nullable|string|max:255',
            'fakultas' => 'nullable|string|max:255',
            'lokasi_foto' => 'nullable|string|max:255',
            'post_foto' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            // 'status_foto' => 'in:Pending,Editing,Complete',
            'harga' => 'required|numeric|min:0',
            'harga_paket_tambahan' => 'nullable|numeric|min:0',
            'dp' => 'required|numeric|min:0',
            'kekurangan' => 'nullable|numeric',
            'pelunasan' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
            'freelance' => 'nullable|numeric|min:0',
            'no_wa' => 'required|string|regex:/^[0-9]+$/|min:10|max:15',
        ];

        $messages = [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal tidak valid.',
            'negara.required' => 'Negara wajib diisi.',
            'negara.string' => 'Negara harus berupa teks.',
            'kota.required' => 'Kota wajib diisi.',
            'kota.string' => 'Kota harus berupa teks.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'jam.required' => 'Jam wajib diisi.',
            // 'jam.date_format' => 'Format jam tidak valid. Gunakan format HH:mm.',
            'kategori_paket.required' => 'Kategori paket wajib diisi.',
            'status_foto.required' => 'Status foto wajib diisi.',
            'status_foto.in' => 'Status foto harus salah satu dari Pending, Editing, atau Complete.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga minimal adalah 1.',
            'harga_paket_tambahan.numeric' => 'Harga harus berupa angka.',
            'harga_paket_tambahan.min' => 'Harga minimal adalah 1.',
            'dp.required' => 'DP wajib diisi.',
            'dp.numeric' => 'DP harus berupa angka.',
            'dp.min' => 'DP minimal adalah 1.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.string' => 'Nomor WhatsApp harus berupa teks.',
            'no_wa.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
            'no_wa.min' => 'Nomor WhatsApp minimal 10 digit.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 15 digit.',
        ];

        $validateData = $request->validate($rules,$messages);

        $pesanan = Pesanan::find($id);
        $booking = Booking::find($pesanan->booking_id);

        $booking->tanggal = $request->tanggal;
        $booking->negara = $request->negara;
        $booking->kota = $request->kota;
        $booking->universitas = $request->universitas;
        $booking->nama = $request->nama;
        $booking->jam = $request->jam;
        $booking->jam_selesai = $request->jam_selesai;
        $booking->fakultas = $request->fakultas;
        $booking->lokasi_foto = $request->lokasi_foto;
        $booking->post_foto = $request->post_foto;
        $booking->dp = $request->dp;
        // $booking->file_dp = $request->file_dp;
        $booking->no_wa = $request->no_wa;
        $booking->save();


        $pesanan->fotografer_id = $request->fotografer_id;
        $pesanan->kekurangan = $request->kekurangan;
        $pesanan->pelunasan = $request->pelunasan;
        $pesanan->discount = $request->discount;
        $pesanan->harga_paket_tambahan = $request->harga_paket_tambahan;
        $pesanan->total = $request->total;
        $pesanan->freelance = $request->freelance;
        $pesanan->keterangan = $request->keterangan;
        $pesanan->status_pembayaran = $request->status_pembayaran;
        $pesanan->save();

        // INSERT FOTO JIKA BELUM ADA DAN BUAT ANTRIAN
        $foto = Foto::where('pesanan_id',$pesanan->id_pesanan)->first();
        $antrianFoto = Foto::where('status_foto', 'Editing')->orderBy('antrian','desc')->first();
        if ($antrianFoto) {
            $antrianFoto = $antrianFoto->antrian;
        } else {
            $antrianFoto = Foto::count();
        }
        if (!$foto) {
            $foto = new Foto();
            $foto->id_foto = 'FT' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            // $foto->status_foto = $request->status_foto;
            // $foto->link = $request->link;
            $foto->pesanan_id = $pesanan->id_pesanan;
            $foto->antrian = $antrianFoto + 1;
            $foto->save();
        } 
        else {
            // $foto->status_foto = $request->status_foto;
            // $foto->link = $request->link;
            $foto->save();
        }

        return redirect()->back()->with('success','Berhasil diperbarui');
        
    }
    
    public function delete($id)
    {
        $pesanan = Pesanan::find($id);
        $pesanan->delete();

        return redirect()->back()->with('success','Pesanan berhasil dihapus');
    }
    
    public function export(Request $request)
    {
        $bulan = $request->input('bulan');
        $formattedBulan = date('F Y', strtotime($bulan)); // Format menjadi "January 2025"
            $formattedBulan = str_replace(
                ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                $formattedBulan
            );
        if ($bulan) {
            return Excel::download(new PesananExport($bulan), 'Laporan_Pesanan_'. $formattedBulan .'.xlsx');
        } else {
            return Excel::download(new PesananExport($bulan), 'Laporan_Pesanan_Keseluruhan.xlsx');
        }
    }

    public function faktur($id)
    {
        $pesanan = Pesanan::find($id);
        // Ambil HTML untuk invoice dari view
        $html = view('exports.faktur',compact('pesanan'))->render(); // pastikan 'invoice' adalah nama view Anda yang berisi HTML yang sudah disiapkan

        // Membuat PDF dari HTML
        $pdf = Pdf::loadHTML($html)->setPaper('legal');
        
        // Menampilkan PDF di browser sebagai preview (tidak langsung diunduh)
        return $pdf->stream('Faktur#' . $pesanan->faktur . '#' . $pesanan->booking->nama . '.pdf'); // Anda bisa mengganti nama file sesuai kebutuhan
    }

    public function add_pelunasan(Request $request,$id)
    {
        
        $request->merge(
            [
                'pelunasan' => str_replace('.', '', $request->pelunasan),
                'dp' => str_replace('.', '', $request->dp)
            ]
        );

        $pesanan = Pesanan::find($id);
        $booking = Booking::find($pesanan->booking_id);

        $booking->dp = $request->dp;

        if ($request->hasFile('file_dp')) {
            $file = $request->file('file_dp');

            // Hapus file lama jika ada
            if ($booking->file_dp) {
                // Menghapus file lama dari storage
                Storage::disk('public')->delete($booking->file_dp);
            }

            $path = 'uploads/dp';

            // Simpan file baru
            $booking->file_dp = $file->store($path, 'public');
        }

        $booking->save();

        // ==============================
        

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

        return redirect()->back()->with('success','Pelunasan berhasil ditambahkan');
    }
}