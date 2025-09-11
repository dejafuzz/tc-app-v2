<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FotoController extends Controller
{
    public function index(){

        // set antrian
        $this->resetAntrian();
        
        $fotos = Foto::with(['pesanan.booking'])
                ->join('pesanan', 'foto.pesanan_id', '=', 'pesanan.id_pesanan')
                ->join('booking', 'pesanan.booking_id', '=', 'booking.id_booking')
                ->orderByRaw("CASE WHEN antrian IS NULL THEN 1 ELSE 0 END, antrian ASC") 
                ->orderByRaw("CASE WHEN status_foto = 'Complete' THEN 1 ELSE 0 END") // "Complete" last
                ->orderBy('booking.tanggal', 'asc') // tetap urut berdasarkan tanggal
                ->select('foto.*')
                ->get();
        
        $antrianFoto = Foto::where('status_foto', 'Editing')->orderBy('antrian','desc')->first();
        
        return view('admin.foto.index',compact('fotos','antrianFoto'));
    }

    protected function resetAntrian()
    {
        DB::transaction(function () {
            DB::table('foto')->update(['antrian' => null]);

            DB::statement("
                UPDATE foto f
                JOIN (
                    SELECT id_foto, ROW_NUMBER() OVER (
                        ORDER BY
                            CASE WHEN status_foto = 'Editing' THEN 1
                                WHEN status_foto = 'List File Edit' THEN 2
                                ELSE 3 END,
                            created_at
                    ) AS rn
                    FROM foto
                    WHERE status_foto IN ('Editing', 'List File Edit')
                ) o ON f.id_foto = o.id_foto
                SET f.antrian = o.rn
            ");
        });
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