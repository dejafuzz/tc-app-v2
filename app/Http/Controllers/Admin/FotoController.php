<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    public function index(){
        // $foto = Foto::where('status_foto','Editing')->get();
        $fotos = Foto::with(['pesanan.booking'])
                ->join('pesanan', 'foto.pesanan_id', '=', 'pesanan.id_pesanan')
                ->join('booking', 'pesanan.booking_id', '=', 'booking.id_booking')
                ->orderByRaw("CASE WHEN status_foto = 'Complete' THEN 1 ELSE 0 END") // "Complete" last
                ->orderBy('booking.tanggal', 'asc') // tetap urut berdasarkan tanggal
                ->select('foto.*')
                ->get();

       // Set antrian secara berurutan
        // $no = 1;
        // foreach ($fotos as $foto) {
        //     $foto->antrian = $no++;
        //     $foto->save();
        // }
        
        $antrianFoto = Foto::where('status_foto', 'Editing')->orderBy('antrian','desc')->first();
        
        return view('admin.foto.index',compact('fotos','antrianFoto'));
    }

    public function update(Request $request,$id)
    {
        $validateData = $request->validate(
            $rules = [
                'status_foto' =>'required',
                'link' => 'nullable',
            ],
            $messages = [
                'status_foto.required' => 'Status Foto wajib diisi',
                'status_foto.in' => 'Status Foto tidak valid',
                'link.required' => 'Link Foto wajib diisi',
            ],
        );

        $foto = Foto::find($id);
        $foto->status_foto = $request->status_foto;
        $foto->link = $request->link;
        $foto->save();

        return redirect()->back()->with('success','Foto berhasil diperbarui');
    }

    public function delete($id)
    {
        $foto = Foto::find($id);
        $foto->delete();

        return redirect()->back()->with('success','Foto berhasil dihapus');
    }
    
}