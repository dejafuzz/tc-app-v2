<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPaket;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{
    public function index(){
        
        $kp = KategoriPaket::all();
        $paket = Paket::all();
        
        return view('admin.paket.index',compact('kp','paket'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'nama_paket' => 'required',
                'fitur' => 'required',
                'kp_id' => 'required|exists:kategori_paket,id_kp',
            ],
            [
                'nama_paket.required' => 'Nama paket wajib diisi',
                'fitur.required' => 'Fitur wajib diisi',
                'kp_id.required' => 'Kategori Paket wajib diisi',
                'kp_id.exists' => 'Kategori Paket tidak valid',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paket = new Paket();
        $paket->id_paket = 'P' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $paket->nama_paket = $request->nama_paket;
        $paket->kp_id = $request->kp_id;
        $paket->fitur = json_encode($request->fitur);
        $paket->save();

        return redirect()->back()->with('success','Paket berhasil ditambahkan');
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), 
            [
                'nama_paket' => 'required',
                'fitur' => 'required',
                'kp_id' => 'required|exists:kategori_paket,id_kp',
            ],
            [
                'nama_paket.required' => 'Nama paket wajib diisi',
                'fitur.required' => 'Fitur wajib diisi',
                'kp_id.required' => 'Kategori Paket wajib diisi',
                'kp_id.exists' => 'Kategori Paket tidak valid',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paket = Paket::find($id);
        $paket->nama_paket = $request->nama_paket;
        $paket->kp_id = $request->kp_id;
        $paket->fitur = json_encode($request->fitur);
        $paket->save();

        return redirect()->back()->with('success', 'Paket berhasil diperbarui');
    }

    public function delete($id)
    {
        $paket = Paket::find($id);
        $paket->delete();

        return redirect()->back()->with('success','Paket berhasil dihapus');
    }
}