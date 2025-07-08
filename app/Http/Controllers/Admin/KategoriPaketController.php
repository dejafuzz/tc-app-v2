<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriPaketController extends Controller
{
    public function index(){
        
        $kp = KategoriPaket::all();
        
        return view('admin.kategori-paket.index',compact('kp'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'nama_kategori' => 'required',
                // 'golongan' => 'required',
                // 'harga' => 'required|numeric',
            ],
            [
                'nama_kategori.required' => 'Nama Kategori wajib diisi',
                'golongan.required' => 'Golongan wajib diisi',
                // 'harga.required' => 'Harga wajib diisi',
                // 'harga.numeric' => 'Harga tidak valid',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kp = new KategoriPaket();
        $kp->id_kp = 'KP' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $kp->nama_kategori = $request->nama_kategori;
        $kp->save();

        return redirect()->back()->with('success', 'Kategori Paket berhasil ditambahkan');
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), 
            [
                'nama_kategori' => 'required',
                // 'golongan' => 'required',
                // 'harga' => 'required|numeric',
            ],
            [
                'nama_kategori.required' => 'Nama Kategori wajib diisi',
                'golongan.required' => 'Golongan wajib diisi',
                // 'harga.required' => 'Harga wajib diisi',
                // 'harga.numeric' => 'Harga tidak valid',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kp = KategoriPaket::find($id);
        $kp->nama_kategori = $request->nama_kategori;
        $kp->save();

        return redirect()->back()->with('success', 'Kategori Paket berhasil diubah');
    }

    public function delete($id)
    {
        $kp = KategoriPaket::find($id);
        $kp->delete();

        return redirect()->back()->with('success', 'Kategori Paket berhasil fihapus');
    }
}