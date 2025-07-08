<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HargaPaket;
use App\Models\Paket;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HargaPaketController extends Controller
{
    public function index(){
        
        $paket = Paket::all();
        $hargaPaket = HargaPaket::all();
        $wilayah = Wilayah::all();
        
        return view('admin.harga-paket.index',compact('paket','hargaPaket'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'harga' => 'required|integer|min:1',
            'golongan' => 'required|string|max:255',
            'paket_id' => 'required|exists:paket,id_paket',
        ], [
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 1.',
            'golongan.required' => 'Golongan wajib diisi.',
            'golongan.string' => 'Golongan harus berupa teks.',
            'golongan.max' => 'Golongan tidak boleh lebih dari 255 karakter.',
            'paket_id.required' => 'Paket ID wajib diisi.',
            'paket_id.exists' => 'Paket ID yang dipilih tidak valid.',
        ]);
        
        $cekHargaPaket = HargaPaket::where('paket_id', $request->paket_id)->where('golongan',$request->golongan)->first();
        if ($cekHargaPaket) {
            return redirect()->back()->with('error','Harga Paket sudah tersedia');
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $hp = new HargaPaket();
        $hp->id_harga_paket = 'HP' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $hp->harga = $request->harga;
        $hp->golongan = $request->golongan;
        $hp->paket_id = $request->paket_id;
        $hp->save();

        return redirect()->back()->with('success','Harga Paket berhasil ditambahkan');
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'harga' => 'required|integer|min:1',
            // 'golongan' => 'required|string|max:255',
            // 'paket_id' => 'required|exists:paket,id_paket',
        ], [
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 1.',
            'golongan.required' => 'Golongan wajib diisi.',
            'golongan.string' => 'Golongan harus berupa teks.',
            'golongan.max' => 'Golongan tidak boleh lebih dari 255 karakter.',
            'paket_id.required' => 'Paket ID wajib diisi.',
            'paket_id.exists' => 'Paket ID yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $hp = HargaPaket::find($id);
        // $hp->paket_id = $request->paket_id;
        // $hp->golongan = $request->golongan;
        $hp->harga = $request->harga;
        $hp->save();

        return redirect()->back()->with('success', 'Harga Paket berhasil diperbaiki');
    }

    public function delete($id)
    {
        $hp = HargaPaket::findOrFail($id);
        $hp->delete();

        return redirect()->back()->with('success','Harga Paket berhasil dihapus');
    }
    
}