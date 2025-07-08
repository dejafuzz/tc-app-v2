<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fotografer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FotograferController extends Controller
{
    public function index(){
        $fg = Fotografer::all();
        return view('admin.fotografer.index',compact('fg'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'nama' => 'required',
                'no_wa' => 'required',
            ],
            [
                'nama.required' => 'Nama wajib diisi',
                'no_wa.required' => 'No WA wajib diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fg = new Fotografer();
        $fg->nama = $request->nama;
        $fg->no_wa = $request->no_wa;
        $fg->save();

        return redirect()->back()->with('success', 'Fotografer berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), 
            [
                'nama' => 'required',
                'no_wa' => 'required',
            ],
            [
                'nama.required' => 'Nama wajib diisi',
                'no_wa.required' => 'No WA wajib diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fg = Fotografer::find($id);
        $fg->nama = $request->nama;
        $fg->no_wa = $request->no_wa;
        $fg->save();

        return redirect()->back()->with('success', 'Fotografer berhasil diperbarui');
    }

    public function delete($id)
    {
        $fg = Fotografer::find($id);
        $fg->delete();
        
        return redirect()->back()->with('success', 'Fotografer berhasil dihapus');
    }
}