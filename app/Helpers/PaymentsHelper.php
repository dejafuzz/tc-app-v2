<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use App\Models\Booking;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PaymentsHelper
{
    public static function helperDp($request, $id)
    {
        $request->merge(['nominal' => str_replace('.', '', $request->nominal)]);

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

        // return redirect()->back()->with('success', 'DP berhasil ditambahkan');
    }

    public static function helperPelunasan($request,$id)
    {
        $request->merge(['nominal' => str_replace('.', '', $request->nominal)]);
        // dd($request->pelunasan);

        $pesanan = Pesanan::where('booking_id',$id)->first();

        $pesanan->pelunasan = $request->nominal;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');

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

        // return redirect()->back()->with('success','Pelunasan sedang diverifikasi oleh Admin');
    }
}