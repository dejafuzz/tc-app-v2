<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPengeluaran;
use App\Models\Pengeluaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Exports\PengeluaranExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Svg\Tag\Rect;

class PengeluaranController extends Controller
{
    public function jenisPengeluaran()
    {
        $jenisPengeluaran = JenisPengeluaran::all();

        return view('admin.jenis_pengeluaran.index',compact('jenisPengeluaran'));
    }


    public function storeJenisPengeluaran(Request $request)
    {
        $request->validate(
            [
                'jenis_pengeluaran' => 'required|unique:jenis_pengeluaran,jenis_pengeluaran',
            ],
            [
                'jenis_pengeluaran.required' => 'Jenis Pengeluaran wajib diisi.',
                'jenis_pengeluaran.unique' => 'Jenis Pengeluaran sudah ada.',
            ]
        );

        $jp = JenisPengeluaran::create(['jenis_pengeluaran' => $request->jenis_pengeluaran]);

        return redirect()->back()->with('success','Jenis Pengeluaran berhasil ditambahkan.');

    }

    public function updateJenisPengeluaran(Request $request,$id)
    {
        $request->validate(
            [
                'jenis_pengeluaran' => 'required|unique:jenis_pengeluaran,jenis_pengeluaran',
            ],
            [
                'jenis_pengeluaran.required' => 'Jenis Pengeluaran wajib diisi.',
                'jenis_pengeluaran.unique' => 'Jenis Pengeluaran sudah ada.',
            ]
        );

        $jp = JenisPengeluaran::find($id)->update(['jenis_pengeluaran' => $request->jenis_pengeluaran]);

        return redirect()->back()->with('success','Jenis Pengeluaran berhasil diperbarui.');
    }

    public function deleteJenisPengeluaran($id)
    {
        JenisPengeluaran::find($id)->delete();

        return redirect()->back()->with('success','Jenis Pengeluaran berhasil dihapus');
    }

// ======================================================================

    // public function pengeluaran()
    // {
    //     $pengeluaran = Pengeluaran::all();
    //     $jenisPengeluaran = JenisPengeluaran::all();

    //     $totalOmsetKotor = Pesanan::where('status_pembayaran', 'Lunas')->sum('total');

    //     return view('admin.pengeluaran.index',compact(['pengeluaran','jenisPengeluaran','totalOmsetKotor']));
    // }

    public function pengeluaran()
    {
        $bulan = request()->get('bulan');
        // $bulan = "2025-03";

        $pengeluaran = Pengeluaran::with('jenis_pengeluaran')
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereYear('tanggal_transaksi', date('Y', strtotime($bulan)))
                    ->whereMonth('tanggal_transaksi', date('m', strtotime($bulan)));
            })
            ->orderByDesc('tanggal_transaksi')
            ->get();

        

        $jenisPengeluaran = JenisPengeluaran::all();
        
        $totalPengeluaran = $pengeluaran->sum('nominal');
        $totalOmsetKotor = Pesanan::where('status_pembayaran', 'Lunas')->sum('total');
        $totalOmsetBersih = $totalOmsetKotor - $totalPengeluaran;
        // if (request()->ajax()) {
        //     return view('admin.pengeluaran.table-body',compact('pengeluaran', 'jenisPengeluaran', 'totalOmsetKotor', 'bulan'));
        // }

        return view('admin.pengeluaran.index', compact('pengeluaran', 'jenisPengeluaran', 'totalOmsetKotor', 'bulan','totalPengeluaran','totalOmsetBersih'));
    }

    public function filter(Request $request)
    {
        $bulan = $request->get('bulan');

        $pengeluaran = Pengeluaran::with('jenis_pengeluaran')
            ->when($bulan, function ($query, $bulan) {
                $query->whereMonth('tanggal_transaksi', '=', date('m', strtotime($bulan)))
                    ->whereYear('tanggal_transaksi', '=', date('Y', strtotime($bulan)));
            })
            ->get();

        $totalOmsetKotor = Pesanan::where('status_pembayaran', 'Lunas')->sum('total');

        $data = $pengeluaran->map(function ($item) {
            return [
                'id_pengeluaran' => $item->id_pengeluaran,
                'tanggal_transaksi' => $item->tanggal_transaksi,
                'jenis_pengeluaran' => $item->jenis_pengeluaran->jenis_pengeluaran,
                'deskripsi' => $item->deskripsi,
                'nominal' => $item->nominal,
            ];
        });

        return response()->json([
            'pengeluaran' => $data,
            'totalPengeluaran' => $pengeluaran->sum('nominal'),
            'totalOmsetBersih' => $totalOmsetKotor - $pengeluaran->sum('nominal'), // contoh hitungan
            'totalOmsetKotor' => $totalOmsetKotor // contoh hitungan
        ]);
    }




    public function storePengeluaran(Request $request)
    {
        $request->merge(
            [
                    'nominal' => str_replace('.', '', $request->nominal)
                ]
        );

        $request->validate(
            [
                'jenis_pengeluaran_id' => 'required|exists:jenis_pengeluaran,id_jenis_pengeluaran',
                'tanggal_transaksi' => 'required|date',
                'deskripsi' => 'required',
                'nominal' => 'required',
            ],
            [
                'jenis_pengeluaran_id.required' => 'Jenis Pengeluaran wajib diisi.',
                'jenis_pengeluaran_id.exists' => 'Jenis Pengeluaran tidak valid.',
                'tanggal_transaksi.required' => 'Tanggal Transaksi wajib diisi.',
                'tanggal_transaksi.date' => 'Tanggal Transaksi tidak valid.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'nominal.required' => 'Nominal wajib diisi.',
            ]
        );

        $pengeluaran = new Pengeluaran();
        $pengeluaran->tanggal_transaksi = $request->tanggal_transaksi;
        $pengeluaran->deskripsi = $request->deskripsi;
        $pengeluaran->nominal = $request->nominal;
        $pengeluaran->jenis_pengeluaran_id = $request->jenis_pengeluaran_id;
        $pengeluaran->save();

        return redirect()->back()->with('success','Pengeluaran berhasil ditambahkan');
    }

    public function updatePengeluaran(Request $request,$id)
    {
        $request->merge(
            [
                    'nominal' => str_replace('.', '', $request->nominal)
                ]
        );

        $request->validate(
            [
                'jenis_pengeluaran_id' => 'required|exists:jenis_pengeluaran,id_jenis_pengeluaran',
                'tanggal_transaksi' => 'required|date',
                'deskripsi' => 'required',
                'nominal' => 'required',
            ],
            [
                'jenis_pengeluaran_id.required' => 'Jenis Pengeluaran wajib diisi.',
                'jenis_pengeluaran_id.exists' => 'Jenis Pengeluaran tidak valid.',
                'tanggal_transaksi.required' => 'Tanggal Transaksi wajib diisi.',
                'tanggal_transaksi.date' => 'Tanggal Transaksi tidak valid.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'nominal.required' => 'Nominal wajib diisi.',
            ]
        );

        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->tanggal_transaksi = $request->tanggal_transaksi;
        $pengeluaran->deskripsi = $request->deskripsi;
        $pengeluaran->nominal = $request->nominal;
        $pengeluaran->jenis_pengeluaran_id = $request->jenis_pengeluaran_id;
        $pengeluaran->save();

        return redirect()->back()->with('success','Pengeluaran berhasil diperbarui');
    }

    public function deletePengeluaran($id)
    {
        $pengeluaran = Pengeluaran::find($id)->delete();
        return redirect()->back()->with('success','Pengeluaran berhasil dihapus');
    }

    public function export()
    {
        $bulan = request()->get('bulan');
        $keseluruhan = "kesuluruhan";
        $namaFile = 'data_pengeluaran_';

        if ($bulan) {
            $formatBulan = Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F_Y');
            $namaFile .= $formatBulan;
        } else {
            $namaFile .= $keseluruhan;
        }

        return Excel::download(new PengeluaranExport($bulan), $namaFile . '.xlsx');
    }

}