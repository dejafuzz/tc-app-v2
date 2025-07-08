<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FastBookingController extends Controller
{
    public function index(){

        $wilayah = Wilayah::all();
        return view ('landing.fastbooking.index',compact('wilayah'));
    }

    public function store(Request $request)
    {
        $rules = [
            'email' => 'email',
        ];

        $validate = $request->validate($rules);

        $cekUser = User::where('email',$request->email)->first();
        $booking = new Booking();

        if (!$cekUser) {
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make(12345678),
                'role_id' => '2',
            ]);
            $booking->user_id = $user->id;
        } 
        else {
            $booking->user_id = $cekUser->id;
        }
        $booking->id_booking = 'BOOK' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $booking->nama = $request->nama;
        $booking->email = $request->email;
        $booking->no_wa = $request->no_wa;
        $booking->ig_client = $request->ig_client;
        $booking->tanggal = $request->tanggal;
        $booking->universitas = $request->universitas;
        $booking->kota = $request->kota;
        $booking->status_booking = 'Pending';
        $booking->save();
        
        return redirect()->back()->with('success', 'Booking berhasil ditambahkan');
    }
}