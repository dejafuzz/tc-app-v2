<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FotoLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FotoLandingController extends Controller
{
    public function index()
    {
        $foto = FotoLanding::all();
        
        return view('admin.foto_landing.index',compact('foto'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'univ' => 'required',
                'keterangan' => 'required',
                'foto' => 'required|file|max:1024|mimes:jpg,jpeg,png,pdf',
            ],
            [
                'univ.required' => 'Universitas wajib diisi',
                'keterangan.required' => 'Keterangan wajib diisi',
                'foto.required' => 'Foto wajib diisi',
                'foto.mimes' => 'Foto harus berupa file JPG, JPEG, PNG, atau PDF.',
                'foto.max' => 'Ukuran foto maksimal 1 MB',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $foto = new FotoLanding();
        $foto->id_foto_landing = Str::upper(Str::random(4));
        $foto->univ = $request->univ;
        $foto->keterangan = $request->keterangan;
        
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            $path = 'uploads/foto_landing';

            // Simpan file baru
            $foto->foto = $file->store($path, 'public');
        }
        $foto->status = 'Pending';
        $foto->save();

        return redirect()->back()->with('success','Foto berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $validator = Validator::make($request->all(), 
            [
                'univ' => 'required',
                'keterangan' => 'required',
                'foto' => 'file|mimes:jpg,jpeg,png,pdf',
            ],
            [
                'univ.required' => 'Universitas wajib diisi',
                'keterangan.required' => 'Keterangan wajib diisi',
                'foto.mimes' => 'Foto harus berupa file JPG, JPEG, PNG, atau PDF.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $foto = FotoLanding::find($id);
        $foto->univ = $request->univ;
        $foto->keterangan = $request->keterangan;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            if ($foto->foto) {
                Storage::disk('public')->delete($foto->foto);
            }

            $path = 'uploads/foto_landing';

            // Simpan file baru
            $foto->foto = $file->store($path, 'public');
        }

        $foto->status = $request->status;
        $foto->save();

        return redirect()->back()->with('success','Foto berhasil diperbarui');
    }

    public function delete($id)
    {
        $foto = FotoLanding::find($id);
        if ($foto->foto) {
            Storage::disk('public')->delete($foto->foto);
        }
        $foto->delete();
        
        return redirect()->back()->with('success','Foto berhasil dihapus');
    }
}