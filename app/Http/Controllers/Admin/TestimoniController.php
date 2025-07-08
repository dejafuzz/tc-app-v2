<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimoni::all();
        return view('admin.testimoni.index',compact('testimoni'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string',
                'event' => 'required|string',
                'deskripsi' => 'required|string',
                'status' => 'required|string',
            ],
            [
                'nama.required' => 'Nama wajib diisi.',
                'nama.string' => 'Nama harus berupa teks.',
                'event.required' => 'Event wajib diisi.',
                'event.string' => 'Event harus berupa teks.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'deskripsi.string' => 'Deskripsi harus berupa teks.',
                'status.required' => 'Status wajib diisi.',
            ]
        );

        $testimoni = new Testimoni();
        $testimoni->id_testimoni = 'TES' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $testimoni->nama = $request->nama;
        $testimoni->event = $request->event;
        $testimoni->deskripsi = $request->deskripsi;
        $testimoni->status = $request->status;
        $testimoni->save();

        return redirect()->back()->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama' => 'required|string',
                'event' => 'required|string',
                'deskripsi' => 'required|string',
                'status' => 'required|string',
            ],
            [
                'nama.required' => 'Nama wajib diisi.',
                'nama.string' => 'Nama harus berupa teks.',
                'event.required' => 'Event wajib diisi.',
                'event.string' => 'Event harus berupa teks.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'deskripsi.string' => 'Deskripsi harus berupa teks.',
                'status.required' => 'Status wajib diisi.',
            ]
        );

        $testimoni = Testimoni::find($id);
        $testimoni->nama = $request->nama;
        $testimoni->event = $request->event;
        $testimoni->deskripsi = $request->deskripsi;
        $testimoni->status = $request->status;
        $testimoni->save();

        return redirect()->back()->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function delete($id)
    {
        $testi = Testimoni::find($id)->delete();

        return redirect()->back()->with('success','Testimoni berhasil dihapus.');
    }
}