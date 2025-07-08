<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketTambahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaketTambahanController extends Controller
{
    public function index(){
        
        $paketTambahan = PaketTambahan::all();
        
        return view('admin.paket-tambahan.index',compact('paketTambahan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'jenis_tambahan' => 'required',
                // 'harga_tambahan' => 'required',
            ],
            [
                'jenis_tambahan.required' => 'Jenis Tambahan wajib diisi',
                'harga_tambahan.required' => 'Harga Tambahan wajib diisi',
                'kp_id.required' => 'Kategori Paket wajib diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paketTambahan = new PaketTambahan();
        $paketTambahan->id_paket_tambahan = 'PT' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $paketTambahan->jenis_tambahan = $request->jenis_tambahan;
        // $paketTambahan->harga_tambahan = $request->harga_tambahan;
        $paketTambahan->save();

        return redirect()->back()->with('success','Paket Tambahan berhasil ditambahkan');
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), 
            [
                'jenis_tambahan' => 'required',
                // 'harga_tambahan' => 'required',
            ],
            [
                'jenis_tambahan.required' => 'Jenis Tambahan wajib diisi',
                'harga_tambahan.required' => 'Harga Tambahan wajib diisi',
                'kp_id.required' => 'Kategori Paket wajib diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paketTambahan = PaketTambahan::find($id);
        $paketTambahan->jenis_tambahan = $request->jenis_tambahan;
        // $paketTambahan->harga_tambahan = $request->harga_tambahan;
        $paketTambahan->save();

        return redirect()->back()->with('success','Paket Tambahan berhasil diperbarui');
    }

    public function delete($id)
    {
        $paketTambahan = PaketTambahan::find($id);
        $paketTambahan->delete();

        return redirect()->back()->with('success','Paket Tambahan berhasil dihapus');
    }
}