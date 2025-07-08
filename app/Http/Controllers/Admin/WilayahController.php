<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WilayahController extends Controller
{
    public function index(){
        
        $wilayah = Wilayah::all();
        
        return view('admin.wilayah.index',compact('wilayah'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'nama_wilayah' => 'required',
                'golongan' => 'required',
                // 'harga' => 'required|numeric',
            ],
            [
                'nama_wilayah.required' => 'Nama Wilayah wajib diisi',
                'golongan.required' => 'Golongan wajib diisi',
                'harga.required' => 'Harga wajib diisi',
                // 'harga.numeric' => 'Harga tidak valid',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $wilayah = new Wilayah();
        $wilayah->id_wilayah = 'WIL' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $wilayah->nama_wilayah = $request->nama_wilayah;
        $wilayah->kode = $request->golongan;
        // $wilayah->harga = $request->harga;
        $wilayah->save();

        return redirect()->back()->with('success', 'Wilayah berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), 
            [
                'nama_wilayah' => 'required',
                'golongan' => 'required',
                // 'harga' => 'required|numeric',
            ],
            [
                'nama_wilayah.required' => 'Nama Wilayah wajib diisi',
                'golongan.required' => 'Golongan wajib diisi',
                // 'harga.required' => 'Harga wajib diisi',
                // 'harga.numeric' => 'Harga tidak valid',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $wilayah = Wilayah::find($id);
        $wilayah->id_wilayah = 'WIL' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $wilayah->nama_wilayah = $request->nama_wilayah;
        $wilayah->kode = $request->golongan;
        // $wilayah->harga = $request->harga;
        $wilayah->save();

        return redirect()->back()->with('success', 'Wilayah berhasil diperbarui');
    }

    public function delete($id)
    {
        $wilayah = Wilayah::find($id);
        $wilayah->delete();

        return redirect()->back()->with('success', 'Wilayah berhasil dihapus');
    }
}