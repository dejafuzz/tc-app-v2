<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    public function add_list_foto(Request $request,$id)
    {
        $antrian = Foto::orderBy('antrian', 'desc')->first()->antrian;
        $antrianFoto = Foto::where('status_foto', 'Editing')->orderBy('antrian','desc')->first();
        

        $pesananId = Pesanan::where('booking_id',$id)->first()->id_pesanan;
        $foto = Foto::where('pesanan_id',$pesananId)->first();
        $foto_edit = json_encode($request->foto_edit);
        $foto->foto_edit = $foto_edit;
        $foto->status_foto = 'List File Edit';
        // $foto->antrian = $antrian + 1;
        $foto->save();

        return redirect()->back()->with('success','Permintaan berhasil dikirim');

    }
}