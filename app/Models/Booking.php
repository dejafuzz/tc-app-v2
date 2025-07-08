<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_booking';
    protected $table = 'booking';
    protected $guarded = [];
    protected $casts = [
        'id_booking' => 'string'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function harga_paket()
    {
        return $this->belongsTo(HargaPaket::class,'harga_paket_id','id_harga_paket');
    }
    public function pesanan()
    {
        return $this->hasOne(Pesanan::class,'booking_id','id_booking');
    }
    
    public function bookingPaketTambahan()
    {
        return $this->hasMany(BookingPaketTambahan::class, 'booking_id', 'id_booking');
    }
    public function paketTambahan()
    {
        return $this->belongsToMany(PaketTambahan::class, 'booking_paket_tambahan', 'booking_id', 'paket_tambahan_id');
    }
    
    public static $rules = [
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'no_wa' => 'required|digits_between:10,15',
        'event' => 'required|string|max:255',
        'tanggal' => 'nullable|date',
        'jam' => 'nullable',
        'kota' => 'required',
        'universitas' => 'required|string|max:255',
        'fakultas' => 'required|string|max:255',
        'lokasi_foto' => 'required|string|max:255',
        'ig_mua' => 'nullable|string|max:255',
        'ig_dress' => 'nullable|string|max:255',
        'ig_nailart' => 'nullable|string|max:255',
        'ig_hijab' => 'nullable|string|max:255',
        'ig_client' => 'nullable|string|max:255',
        'post_foto' => 'required|in:Bersedia,Tidak Bersedia',
        'jumlah_anggota' => 'required|integer|min:1',
        'req_khusus' => 'nullable|string|max:1000',
        'status_booking' => 'in:Pending,Diterima,Ditolak,Dibatalkan',
        'harga_paket_id' => 'required|exists:harga_paket,id_harga_paket',
        'user_id' => 'exists:users,id',
        
        'dp' => 'nullable|min:0',
        'file_dp' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf',
    ];

    public static $messages = [
        'nama.required' => 'Nama wajib diisi.',
        'nama.max' => 'Nama maksimal 255 karakter.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
        'no_wa.digits_between' => 'Nomor WhatsApp harus antara 10-15 digit.',
        'event.required' => 'Event wajib diisi.',
        'tanggal.date' => 'Tanggal harus berupa format tanggal yang valid.',
        'jam.date_format' => 'Jam harus menggunakan format HH:mm (24 jam).',
        'universitas.required' => 'Universitas wajib diisi.',
        'fakultas.required' => 'Fakultas wajib diisi.',
        'lokasi_foto.required' => 'Lokasi Foto wajib diisi.',
        'post_foto.required' => 'Post Foto wajib diisi.',
        'kota.required' => 'Kota wajib diisi.',
        'post_foto.in' => 'Post Foto hanya dapat diisi dengan "yes" atau "no".',
        'jumlah_anggota.required' => 'Jumlah anggota wajib diisi.',
        'jumlah_anggota.integer' => 'Jumlah anggota harus berupa angka.',
        'jumlah_anggota.min' => 'Jumlah anggota minimal 1.',
        'status_booking.required' => 'Status Booking wajib diisi.',
        'status_booking.in' => 'Status Booking harus salah satu dari: Pendding, Diterima, Ditolak, Dibatalkan.',
        // 'user_id.required' => 'User ID wajib diisi.',
        'user_id.exists' => 'User ID tidak ditemukan.',
        'harga_paket_id.required' => 'Paket wajib diisi.',
        'harga_paket_id.exists' => 'Harga Paket tidak ditemukan.',

        'dp.min' => 'Jumlah DP tidak valid.',
        'file_dp.mimes' => 'File DP harus berupa file dengan format: jpg, jpeg, png, gif, atau pdf.',
        'file_dp.max' => 'File DP tidak boleh lebih dari 2MB.',
    ];

    public static $ig_mua = 'IG MUA';
    public static $ig_dress = 'IG KEBAYA/JASS';
    public static $ig_nailart = 'IG NAILART';
    public static $ig_hijab = 'IG HIJABDO/HAIRDO';
}