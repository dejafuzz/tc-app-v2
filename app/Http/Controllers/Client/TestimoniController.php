<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimoni::where('status', 'Posted')->get();
        return view('admin.testimoni.index',compact('testimoni'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string',
                'event' => 'required|string',
                'deskripsi' => 'required|string',
            ],
            [
                'nama.required' => 'Nama wajib diisi.',
                'nama.string' => 'Nama harus berupa teks.',
                'event.required' => 'Event wajib diisi.',
                'event.string' => 'Event harus berupa teks.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'deskripsi.string' => 'Deskripsi harus berupa teks.',
            ]
        );

        $testimoni = new Testimoni();
        $testimoni->id_testimoni = 'TES' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $testimoni->nama = $request->nama;
        $testimoni->event = $request->event;
        $testimoni->deskripsi = $request->deskripsi;
        $testimoni->status = 'Pending';
        $testimoni->save();

        return redirect()->back()->with('success', 'Testimoni berhasil ditambahkan.');
    }
}