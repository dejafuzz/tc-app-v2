@extends('layouts.master')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">KELOLA BOOKING <strong>ACCEPTED</strong></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Booking <strong>Accepted</strong></h6>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-solid fa-folder-plus fa-sm text-white-50"></i> Tambah Booking
            </button>
        </div>

        @include('admin.booking.modal-tambah-booking',['hargaPaket' => $hargaPaket])

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover nowrap" id="booking" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th style="text-align: center">NO</th>
                            <th style="text-align: center">NAMA</th>
                            <th style="text-align: center">WHATSAPP</th>
                            <th style="text-align: center">STATUS</th>
                            <th style="text-align: center">IG CLIENT</th>
                            <th style="text-align: center">UNIVERSITAS</th>
                            <th style="text-align: center">FAKULTAS</th>
                            <th style="text-align: center">TANGGAL FOTO</th>
                            <th style="text-align: center">JAM</th>
                            <th style="text-align: center">EVENT</th>
                            <th style="text-align: center">LOKASI FOTO</th>
                            <th style="text-align: center">PAKET</th>
                            {{-- <th style="text-align: center">{{ \App\Models\Booking::$ig_mua }}</th>
                            <th style="text-align: center">{{ \App\Models\Booking::$ig_dress }}</th>
                            <th style="text-align: center">{{ \App\Models\Booking::$ig_nailart }}</th>
                            <th style="text-align: center">{{ \App\Models\Booking::$ig_hijab }}</th> --}}
                            <th style="text-align: center">POST FOTO</th>
                            <th style="text-align: center">JML ANGGOTA</th>
                            <th style="text-align: center">CATATAN</th>
                            <th style="text-align: center">HARGA PKT</th>
                            <th style="text-align: center">HARGA PKT TMBHN</th>
                            <th style="text-align: center">TOT HARGA</th>
                            <th style="text-align: center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking as $item)
                            <tr class="text-center">
                                {{-- <td style="max-width: 200px; width: 100px; text-align: center">{{ $loop->iteration + ($booking->currentPage() - 1) * $booking->perPage() }}</td> --}}
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td style="text-align: left">
                                    <!-- Mengubah nomor WA jika dimulai dengan '0' -->
                                    @php
                                        $waNumber = $item->no_wa;
                                        // Cek apakah nomor WA dimulai dengan '0'
                                        if (substr($waNumber, 0, 1) === '0') {
                                            $waNumber = '62' . substr($waNumber, 1); // Ganti '0' dengan '62'
                                        }
                                    @endphp
                                    
                                    <!-- Menampilkan nomor WA dengan ikon WhatsApp -->
                                    <a href="https://wa.me/{{ $waNumber }}" target="_blank">
                                        <i class="fab fa-whatsapp"></i> {{ $waNumber }}
                                    </a>
                                </td>
                                <td>
                                    @if ($item->status_booking == 'Pending')
                                        <span class="badge badge-info">{{ $item->status_booking }}</span>
                                    @elseif ($item->status_booking == 'Accepted')
                                        <span class="badge badge-success">{{ $item->status_booking }}</span>
                                    @elseif ($item->status_booking == 'Rejected')
                                        <span class="badge badge-warning">{{ $item->status_booking }}</span>
                                    @elseif ($item->status_booking == 'Cancelled')
                                        <span class="badge badge-danger">{{ $item->status_booking }}</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- IG Client, menghapus '@' jika ada -->
                                    @php
                                        $igClient = $item->ig_client;
                                        if ($igClient && substr($igClient, 0, 1) === '@') {
                                            $igClient = substr($igClient, 1); // Hapus '@' di depan
                                        }
                                    @endphp
                                    @if ($igClient)
                                        <a href="https://instagram.com/{{ $igClient }}" target="_blank">
                                            <i class="fab fa-instagram"></i> {{ $igClient }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->universitas }}</td>
                                <td>{{ $item->fakultas }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') ?? '-' }}</td>
                                @php
                                    $jamMulai = $item->jam ? Carbon\Carbon::parse($item->jam)->format('H:i') : null;
                                @endphp
                                <td>
                                    @if ($item->jam_selesai)
                                    {{ $jamMulai . '-' . $item->jam_selesai }}
                                    @else
                                        {{ $jamMulai ?? '-' }}
                                        @endif
                                </td>
                                <td>{{ $item->event }}</td>
                                <td>{{ $item->lokasi_foto }}</td>
                                <td>{{ $item->harga_paket?->paket->kategori_paket->nama_kategori . ' ' . $item->harga_paket?->paket->nama_paket }}</td>
                                <td>
                                    @if ($item->post_foto == 'Bersedia')
                                        <span class="badge badge-success">{{ $item->post_foto }}</span>
                                    @elseif ($item->post_foto == 'Tidak Bersedia')
                                        <span class="badge badge-danger">{{ $item->post_foto }}</span>
                                    @else
                                        -
                                    @endif
                                <td style="text-align: center">{{ $item->jumlah_anggota ?? '-' }}</td>
                                <td>{{ $item->req_khusus ?? '-' }}</td>
                                <td>{{ 'Rp ' . number_format($item->harga_paket?->harga, 0, ',', '.') }}</td>

                                {{-- PKT TMBHN --}}
                                @php
                                    // $paket_tambahan = [];
                                    // if ( $item->paketTambahan) {
                                    //     foreach ($item->paketTambahan as $pt) {
                                    //         $paket_tambahan[] = $pt->jenis_tambahan;
                                    //     }
                                    // }
                                    // $hargaPaketTambahan = $item->paketTambahan->sum('harga_tambahan');
                                    $hargaPaketTambahan = $item->pesanan?->harga_paket_tambahan;
                                @endphp
                                <td>{{ 'Rp ' . number_format($hargaPaketTambahan, 0, ',', '.') ?? '-' }}</td>
                                <td>{{ 'Rp ' . number_format($item->harga_paket?->harga + $hargaPaketTambahan, 0, ',', '.') ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_booking }}" title="Update">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </a>
                                        <a href="" class="btn btn-info btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalDP{{ $item->id_booking }}" title="Bukti DP">
                                            <i class="fas fa-money-bill"></i>
                                        </a>

                                        
                                        {{-- <form action="{{ route('admin.ubah.status.booking',$item->id_booking) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="status_booking" value="Accepted">
                                            <button class="btn btn-success btn-circle btn-acc btn-sm mr-2" type="submit"><i class="fas fa-solid fa-check"></i></button>
                                        </form> --}}

                                        <form action="{{ route('admin.ubah.status.booking', $item->id_booking) }}" method="post" class="accept-form">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="status_booking" value="Accepted">
                                            <button title="Terima"
                                                class="btn btn-success btn-circle btn-acc btn-sm mr-2" 
                                                type="button" 
                                                data-phone="{{ $item->no_wa }}"
                                            >
                                                <i class="fas fa-solid fa-check"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.ubah.status.booking',$item->id_booking) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="status_booking" value="Rejected">
                                            <button title="Tolak/Cancel" class="btn btn-info btn-circle btn-reject btn-sm mr-2" type="submit"><i class="fas fa-times"></i></button>
                                        </form>
                                        <form action="{{ route('admin.delete.booking',$item->id_booking) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-circle btn-sm delete-btn mr-2" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                            {{-- SweetAlert Delete --}}
                            
<script>
    function formatNumber(input) {
        // Menghapus semua karakter selain angka
        let value = input.value.replace(/\D/g, '');
    
        // Menambahkan titik setiap 3 digit
        let formattedValue = new Intl.NumberFormat('id-ID').format(value);
    
        // Mengatur kembali nilai input
        input.value = formattedValue;
    }
</script>

                            {{-- @include('admin.booking.modal-test',['item' => $item]) --}}


                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="d-flex justify-content-center mt-3">
                    {{ $booking->links() }}
                </div> --}}

                
            </div>
        </div>
    </div>

    @foreach ($booking as $item)
    {{-- EDIT --}}
    <form action="{{ route('admin.update.booking',$item->id_booking) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="modal fade" id="modalEdit{{ $item->id_booking }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEdit{{ $item->id_booking }}">Update Booking</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    
                        <div class="modal-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama" class="col-form-label">Nama</label>
                                        <input type="text" value="{{ old('nama',$item->nama) }}" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Masukkan nama lengkap">
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input type="email" value="{{ old('email',$item->email) }}" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukkan alamat email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_wa" class="col-form-label">WhatsApp</label>
                                        <input type="text" value="{{ old('no_wa',$item->no_wa) }}" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror" id="no_wa" placeholder="Masukkan nomor WhatsApp">
                                        @error('no_wa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="event" class="col-form-label">Event</label>
                                        <input type="text" value="{{ old('event',$item->event) }}" name="event" class="form-control @error('event') is-invalid @enderror" id="event" placeholder="Contoh: Wisuda, Tunangan, dll">
                                        @error('event')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal" class="col-form-label">Tanggal</label>
                                        <input type="date" value="{{ old('tanggal',$item->tanggal) }}" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal">
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jam" class="col-form-label">Jam Mulai</label>
                                        <input type="time" value="{{ old('jam',$item->jam) }}" name="jam" class="form-control @error('jam') is-invalid @enderror" id="jam">
                                        @error('jam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ig_client" class="col-form-label">IG Client</label>
                                        <input type="text" value="{{ old('ig_client',$item->ig_client) }}" name="ig_client" class="form-control @error('ig_client') is-invalid @enderror" id="ig_client" placeholder="Username Instagram Client">
                                        @error('ig_client')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="universitas" class="col-form-label">Universitas</label>
                                        <input type="text" value="{{ old('universitas',$item->universitas) }}" name="universitas" class="form-control @error('universitas') is-invalid @enderror" id="universitas" placeholder="Masukkan nama universitas">
                                        @error('universitas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="fakultas" class="col-form-label">Fakultas</label>
                                        <input type="text" value="{{ old('fakultas',$item->fakultas) }}" name="fakultas" class="form-control @error('fakultas') is-invalid @enderror" id="fakultas" placeholder="Masukkan nama fakultas">
                                        @error('fakultas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="lokasi_foto" class="col-form-label">Lokasi Foto</label>
                                        <input type="text" value="{{ old('lokasi_foto',$item->lokasi_foto) }}" name="lokasi_foto" class="form-control @error('lokasi_foto') is-invalid @enderror" id="lokasi_foto" placeholder="Tempat/lokasi foto">
                                        @error('lokasi_foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah_anggota" class="col-form-label">Jumlah Anggota</label>
                                        <input type="text" value="{{ old('jumlah_anggota',$item->jumlah_anggota) }}" name="jumlah_anggota" class="form-control @error('jumlah_anggota') is-invalid @enderror" id="jumlah_anggota" placeholder="Jumlah orang dalam foto">
                                        @error('jumlah_anggota')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jam_selesai" class="col-form-label">Jam Selesai</label>
                                        <input type="time" value="{{ old('jam_selesai',$item->jam_selesai) }}" name="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" id="jam_selesai">
                                        @error('jam_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kota" class="col-form-label">Kota/Kabupaten</label>
                                        <input type="text" value="{{ old('kota',$item->kota) }}" name="kota" class="form-control @error('kota') is-invalid @enderror" id="kota">
                                        @error('kota')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="post_foto" class="col-form-label">Post Foto</label>
                                        <select id="post_foto" name="post_foto" class="form-control @error('post_foto') is-invalid @enderror">
                                            <option selected disabled value="">--Pilih--</option>
                                            <option value="Bersedia" {{ old('post_foto',$item->post_foto) == 'Bersedia' ? 'selected' : '' }}>Bersedia</option>
                                            <option value="Tidak Bersedia" {{ old('post_foto',$item->post_foto) == 'Tidak Bersedia' ? 'selected' : '' }}>Tidak Bersedia</option>
                                        </select>
                                        @error('post_foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Full Width Fields -->
                            
                            <div class="form-group">
                                <label for="harga_paket_id" class="col-form-label">Paket</label>
                                <select id="harga_paket_id" name="harga_paket_id" class="form-control js-example-basic-single-update @error('harga_paket_id') is-invalid @enderror">
                                    <option selected disabled value="">--Pilih Paket--</option>
                                    @foreach ($hargaPaket    as $harga)
                                        <option value="{{ $harga->id_harga_paket }}" 
                                            {{ old('harga_paket_id',$item->harga_paket_id) == $harga->id_harga_paket ? 'selected' : '' }}>
                                            
                                            {{ $harga->paket->kategori_paket->nama_kategori . ' ' . $harga->paket->nama_paket . ' | ' }}
                                            
                                            @php
                                                $namaWilayah = \App\Models\Wilayah::where('kode', $harga->golongan)->pluck('nama_wilayah')->toArray();
                                            @endphp
                            
                                            {{ implode(', ', $namaWilayah) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('harga_paket_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="discount" class="col-form-label">Discount</label>
                                <input type="number" value="{{ old('discount', $item->discount) }}" name="discount" class="form-control @error('discount') is-invalid @enderror" id="discount">
                                @error('discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kp_id" class="col-form-label">Pilih Paket Tambahan</label>
                                <select class="form-control js-paket-tambahan" 
                                    style="width: 100%; height: 300px;" 
                                    multiple="multiple" name="paket_tambahan[]">
                                    @foreach ($paketTambahan as $pt)
                                        <option value="{{ $pt->id_paket_tambahan }}" 
                                            @if (isset($item) && $item->paketTambahan->contains('id_paket_tambahan', $pt->id_paket_tambahan)) selected @endif>
                                            {{ $pt->jenis_tambahan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="req_khusus" class="col-form-label">Catatan</label>
                                <textarea name="req_khusus" class="form-control @error('req_khusus') is-invalid @enderror" id="req_khusus" rows="3" placeholder="Masukkan catatan atau permintaan khusus">{{ old('req_khusus',$item->req_khusus) }}</textarea>
                                @error('req_khusus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    
                </div>
            </div>
        </div>
</form>



<script>
    function formatNumber(input) {
        // Menghapus semua karakter selain angka
        let value = input.value.replace(/\D/g, '');
    
        // Menambahkan titik setiap 3 digit
        let formattedValue = new Intl.NumberFormat('id-ID').format(value);
    
        // Mengatur kembali nilai input
        input.value = formattedValue;
    }
</script>

<!-- Modal file -->
<form action="{{ route('admin.update.dpbooking',$item->id_booking) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="modal fade" id="modalDP{{ $item->id_booking }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel{{ $item->id_booking }}">Bukti Pembayaran <span class="font-weight-bold">{{ $item->nama }}</span> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    @if ($item->file_dp)
                        <span class="text-muted text-center">Bukti DP</span> <br>
                        <img src="{{ asset('storage/' . $item->file_dp) }}" class="card-img-top" alt="...">
                    @else
                        <p class="text-muted text-center">Bukti DP Tidak ditemukan!</p>
                    @endif
                    <hr>
                    @if ($item->file_pelunasan)
                        <span class="text-muted text-center">Bukti Pelunasan</span> <br>
                        <img src="{{ asset('storage/' . $item->file_pelunasan) }}" class="card-img-top" alt="...">
                    @endif

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</form>
    @endforeach


    <script>
                                document.querySelectorAll('.btn-acc').forEach(button => {
                                    button.addEventListener('click', function (e) {
                                        e.preventDefault(); // Mencegah pengiriman form langsung
                            
                                        const form = this.closest('form'); // Ambil form terdekat dari tombol yang diklik
                                        let phoneNumber = this.getAttribute('data-phone'); // Ambil nomor WhatsApp dari atribut data-phone
                            
                                        // Cek jika nomor telepon dimulai dengan 0 dan ganti menjadi 62
                                        if (phoneNumber.startsWith('0')) {
                                            phoneNumber = '62' + phoneNumber.slice(1);
                                        }
                            
                                        // Cek jika nomor telepon valid
                                        console.log('Phone number:', phoneNumber);
                            
                                        // Popup konfirmasi menggunakan SweetAlert2
                                        Swal.fire({
                                            title: 'Apakah booking ini akan diterima?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Ya, Terima',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // Log untuk memastikan form submit
                                                console.log('Form will be submitted!');
                                                form.submit();
                            
                                                // Format nomor telepon (hilangkan karakter selain angka)
                                                const formattedPhoneNumber = phoneNumber.replace(/\D/g, '');
                                                console.log('Formatted phone number:', formattedPhoneNumber);
                            
                                                // Template pesan WhatsApp yang akan dikirim
                const message = `Terimakasih ka, Dp sudah masuk yah 
Selanjutnya, Kaka akan di hubungi oleh team FG kita di H-2 atau H-1 Wisuda yah ka.
                
*Untuk Pelunasan setelah sesi Foto selesai, dan bukti Transfer untuk syarat akses Link Hasil foto pada hari itu,*

Link foto akan dikirimkan setelah proses Upload ke G-drive selesai yah ka (Malam Hari/Ke-esokan harinya Maksimal H+2)

Proses edit akan berlangsung maksimal 3-10hari,
*Apabila setelah mendapat link dan belum melilih photo sampai selama 3 hari*, pemilihan photo untuk edit akan di serahkan kepada team Tersimpan Cerita yah ka
                
*Penting!!*
Apabila Cancel secara sepihak maka DP akan hangus , untuk Reschedule Tanggal dan Jam dilakukan H-7 (*Dengan catatan Jam yang di inginkan masih kosong, apabila penuh maka sesuai dengan Booking awal*)
                
Terimakasih,
See you on your happy day kaa`;
                            
                                                // Encode pesan untuk URL (karena URL harus aman)
                                                const encodedMessage = encodeURIComponent(message);
                            
                                                // Buat URL WhatsApp
                                                const whatsappUrl = `https://wa.me/${formattedPhoneNumber}?text=${encodedMessage}`;
                            
                                                // Log untuk mengecek URL WhatsApp
                                                console.log('WhatsApp URL:', whatsappUrl);
                            
                                                // Buka WhatsApp di jendela/tab baru dengan pengaturan keamanan
                                                window.open(whatsappUrl, '_blank', 'noopener,noreferrer');
                                            }
                                        });
                                    });
                                });
                            </script>


    <script>
        // Pilih semua tombol dengan kelas delete-btn
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah pengiriman form langsung
    
                const form = this.closest('form'); // Ambil form terdekat dari tombol yang diklik
    
                Swal.fire({
                    title: 'Apakah booking ini akan dihapus?',
                    // text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Kirim form jika pengguna mengonfirmasi
                    }
                });
            });
        });
    </script>

    <script>
        // Pilih semua tombol dengan kelas delete-btn
        document.querySelectorAll('.btn-reject').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah pengiriman form langsung
    
                const form = this.closest('form'); // Ambil form terdekat dari tombol yang diklik
    
                Swal.fire({
                    title: 'Apakah booking ini akan ditolak?',
                    // text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Kirim form jika pengguna mengonfirmasi
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 saat modal ditampilkan
            $('#modalTambah').on('shown.bs.modal', function () {
                $('.js-example-basic-single').select2({
                    dropdownParent: $('#modalTambah') // Pastikan dropdown berada dalam modal
                });
            });
        });
        $(document).ready(function() {
            // Inisialisasi Select2 saat modal dengan ID yang dimulai dengan "modalEdit" ditampilkan
            $('div[id^="modalEdit"]').on('shown.bs.modal', function () {
                $(this).find('.js-example-basic-single-update').select2({
                    dropdownParent: $(this) // Pastikan dropdown berada dalam modal yang benar
                });
            });
        });
    </script>

    <script>
        $(".js-paket-tambahan").select2({
            // tags: true,                 // Mengizinkan input custom
            allowClear: true,           // Mengizinkan penghapusan semua pilihan
            placeholder: "-- Pilih Paket Tambahan --", // Placeholder untuk dropdown
            createTag: function(params) {
                var term = $.trim(params.term); // Menghapus spasi ekstra
                if (term === '') {
                    return null; // Jangan tambahkan tag jika input kosong
                }
                return {
                    id: term,
                    text: term,
                    newTag: true // Tandai bahwa ini adalah tag baru
                };
            },
            tokenSeparators: [] // Menghapus pemisah token, memungkinkan input spasi
        });
    </script>

    
@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection