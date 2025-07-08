<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\PaketLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaketLandingController extends Controller
{
    public function index(){
        $paket = Paket::all();
        $paketLanding = PaketLanding::with('paket')->get(); // biar relasi ikut ke-load
        return view('admin.paket_landing.index', compact('paket', 'paketLanding'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paket_id' => 'required|exists:paket,id_paket',
            'status' => 'required|string|max:255',
        ], [
            'status.required' => 'Status wajib diisi.',
            'paket_id.required' => 'Paket ID wajib diisi.',
            'paket_id.exists' => 'Paket ID yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        PaketLanding::create([
            'paket_id' => $request->paket_id,
            'status' => $request->status,
        ]);
        return redirect()->back()->with('success', 'Paket berhasil ditambahkan');
    }

    public function edit($id)
    {
        $paketLanding = PaketLanding::findOrFail($id);
        $paket = Paket::all();
        return view('admin.paket-landing.edit', compact('paketLanding', 'paket'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'paket_id' => 'required|exists:paket,id_paket',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paketLanding = PaketLanding::findOrFail($id);
        $paketLanding->update([
            'paket_id' => $request->paket_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.paket.landing')->with('success', 'Paket berhasil diperbarui');
    }

    public function delete($id)
    {
        $paketLanding = PaketLanding::findOrFail($id);
        $paketLanding->delete();

        return redirect()->back()->with('success', 'Paket berhasil dihapus');
    }
}