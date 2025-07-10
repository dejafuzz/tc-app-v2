@extends('layouts.master')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">DAFTAR BOOKING</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Booking</h6>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-solid fa-folder-plus fa-sm text-white-50"></i> Tambah Booking
            </button>
        </div>



        @include('client.booking.modal-tambah-booking',['hargaPaket' => $hargaPaket])
        

        {{-- Konten Card --}}
        <div class="card-body">
            <div class="row">
                @if ($booking->isEmpty())
                    <span class="text-muted text-center">Tidak ada Booking!</span>
                @endif
                @foreach ($booking as $item)
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title text-primary mb-0">{{ $item->nama ?? '-' }}</h5>
                                    <span class="badge badge-{{ $item->status_booking == 'Accepted' ? 'success' : ($item->status_booking == 'Pending' ? 'info' : ($item->status_booking == 'Rejected' ? 'warning' : ($item->status_booking == 'Cancelled' ? 'danger' : 'warning' ))) }}">
                                        {{ $item->status_booking }}
                                    </span>
                                </div>
                                <p class="card-text mt-2">
                                    <strong>Event:</strong> {{ $item->event ?? '-' }}<br>
                                    <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') ?? '-' }}<br>
                                    
                                    @php
                                        $jamMulai = $item->jam ? Carbon\Carbon::parse($item->jam)->format('H:i') : null;
                                        $jamSelesai = $item->jam_selesai ? Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : null;
                                    @endphp
                                    <strong>Jam:</strong> {{ $jamSelesai ? $jamMulai . ' - ' . $jamSelesai : ($jamMulai ?? '-') }} <br>

                                    <strong>Fotograger:</strong> {{ $item->pesanan?->fotografer?->nama ?? '-' }} <br>
                                    @if ($item?->pesanan?->foto && $item->status_booking == 'Accepted')
                                        <strong>Status Foto:</strong> 
                                        @if ($item->pesanan?->foto?->status_foto == 'Waiting for Photoshoot')
                                            <span class="badge badge-secondary">{{ $item->pesanan?->foto?->status_foto }}</span>
                                        @elseif ($item->pesanan?->foto?->status_foto == 'Uploading File')
                                            <span class="badge badge-info">{{ $item->pesanan?->foto?->status_foto }}</span>
                                        @elseif ($item->pesanan?->foto?->status_foto == 'Sending File')
                                            <span class="badge badge-warning">{{ $item->pesanan?->foto?->status_foto }}</span>
                                        @elseif ($item->pesanan?->foto?->status_foto == 'List File Edit')
                                            <span class="badge badge-info">{{ $item->pesanan?->foto?->status_foto }}</span>
                                        @elseif ($item->pesanan?->foto?->status_foto == 'Editing')
                                            <span class="badge badge-primary">{{ $item->pesanan?->foto?->status_foto }}</span>
                                        @elseif ($item->pesanan?->foto?->status_foto == 'Complete')
                                            <span class="badge badge-success">{{ $item->pesanan?->foto?->status_foto }}</span>
                                        @else
                                            -
                                        @endif
                                    @endif
                                    <br>
                                    @if ($item->status_booking == 'Accepted')
                                        @if ($item->pesanan?->discount)
                                            <strong>Discount:</strong> {{ 'Rp. ' . number_format($item->pesanan->discount, 0, ',', '.') ?? '-' }} <br>
                                        @endif
                                        <strong>Kekurangan:</strong> {{ 'Rp. ' . number_format($item->pesanan->kekurangan, 0, ',', '.') ?? '-' }} 
                                        @if ($item->pesanan?->status_pembayaran == 'Lunas')
                                            <span class="badge badge-success">{{ $item->pesanan?->status_pembayaran }}</span> <br>
                                        @elseif ($item->pesanan?->kekurangan <= 0)
                                            <span class="badge badge-info">Sedang diverifikasi</span> <br>
                                        @else
                                            <span class="badge badge-danger">Belum Lunas</span> <br>
                                        @endif
                                    @endif
                                    
                                    {{-- Foto --}}
                                    @php
                                        $jumlahAntrian = \App\Models\Foto::orderBy('antrian', 'desc')->first()->antrian;
                                        $antrianAnda = \App\Models\Foto::where('pesanan_id',$item->pesanan?->id_pesanan)->first();

                                        if ($antrianAnda) {
                                            $antrianAnda = $antrianAnda->antrian;
                                        } else {
                                            $antrianAnda = null;
                                        }

                                        // $cekAntrian = \App\Models\Foto::where('status_foto','Editing')->orderBy('antrian','asc')->first();
                                        // if ($cekAntrian) {
                                        //     $antrianSekarang = $cekAntrian->antrian;
                                        // } else {
                                        //     $antrianSekarang = $jumlahAntrian;
                                        // }
                                        $cekAntrian = \App\Models\Foto::where('status_foto','Complete')->orderBy('antrian','desc')->first();
                                        
                                        if ($cekAntrian) {
                                            $antrianSekarang = $cekAntrian->antrian + 1;
                                        } else {
                                            $antrianSekarang = $jumlahAntrian;
                                        }
                                    @endphp
                                    @if ($item?->pesanan?->foto->status_foto == 'List File Edit')
                                        <strong>Antrian Anda:</strong> <span class="badge badge-dark">{{ $antrianAnda }}</span> <br>
                                        <strong>Antrian Sekarang:</strong> <span class="badge badge-dark">{{ $antrianSekarang . '/' . $jumlahAntrian }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="d-flex justify-content-center flex-wrap mb-4">
                                @if ($item->status_booking != 'Cancelled')
                            
                                    @if ($item->status_booking != 'Accepted')
                                        <!-- Tombol Update -->
                                        <button 
                                            class="btn btn-sm btn-warning mt-3 mr-2" 
                                            {{ $item->pesanan?->foto?->status_foto == 'Complete' ? 'disabled' : '' }} 
                                            data-toggle="modal" 
                                            data-target="#modalEdit{{ $item->id_booking }}">
                                            Lengkapi Data
                                        </button>
                                    @endif
                            
                                    @if ($item->pesanan?->status_pembayaran != 'Lunas')
                                        <!-- Tombol File -->
                                        <a 
                                            href="{{ asset('storage/' . $item->file_dp) }}" 
                                            class="btn btn-sm btn-info mt-3 mr-2" 
                                            data-toggle="modal" 
                                            data-target="#fileModal{{ $item->id_booking }}">
                                            Pembayaran
                                        </a>
                                
                                        {{-- @if ($item->status_booking == 'Accepted')
                                            <!-- Tombol Pelunasan -->
                                            <button 
                                                class="btn btn-sm btn-dark mt-3 mr-2" 
                                                data-toggle="modal" 
                                                data-target="#modalPelunasan{{ $item->id_booking }}">
                                                Pelunasan
                                            </button>

                                        @endif --}}
                                    @endif
                            
                                    @if ($item->pesanan)
                                        <!-- Tombol Pilih Foto Edit -->
                                        <button 
                                            class="btn btn-sm btn-primary mt-3 mr-2" 
                                            data-toggle="modal" 
                                            data-target="#modalEditFoto{{ $item->id_booking }}">
                                            Pilih Foto Edit
                                        </button>
                                    @endif
                            
                                    <!-- Tombol Lihat Detail -->
                                    <button 
                                        class="btn btn-sm btn-success mt-3 mr-2" 
                                        data-toggle="modal" 
                                        data-target="#detailModal{{ $item->id_booking }}">
                                        Lihat Detail
                                    </button>
                            
                                    @if ($item->status_booking != 'Accepted')
                                        <!-- Form Cancel -->
                                        <form 
                                            action="{{ route('client.ubah.status.booking', $item->id_booking) }}" 
                                            method="POST" 
                                            class="mt-3 mr-2 cancel-form">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="status_booking" value="Cancelled">
                                            <button 
                                                type="submit" 
                                                class="btn btn-secondary btn-sm cancel-btn" 
                                                title="Cancel">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                            
                                @endif
                            </div>                            
                        </div>
                    </div>

                    <!-- Modal file DP -->
                    <form id="pembayaranForm{{ $item->id_booking }}" action="{{ route('client.add.pembayaran', ['id' => $item->id_booking]) }}"  method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                        <input type="hidden" id="no_wa{{ $item->id_booking }}" value="{{ $item->no_wa }}">
                        <div class="modal fade" id="fileModal{{ $item->id_booking }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel{{ $item->id_booking }}">Pembayaran DP dan Pelunasan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            @if ($item->pesanan)
                                                <h6 class="mb-1"><strong><i class="fas fa-fw fa-credit-card"></i> Informasi Pembayaran</strong></h6>
                                                <!-- Tombol Cepitir -->
                                                <a
                                                    href="{{ route('client.export.faktur',$item->pesanan?->id_pesanan) }}" download style="text-decoration: underline;"><i class="fas fa-fw fa-file"></i>Download Faktur
                                                </a>

                                                <p class="mb-1">Silakan lakukan Pelunasan dari kekurangan: <strong>{{ 'Rp. ' . number_format($item->pesanan->kekurangan, 0, ',', '.') ?? '-' }} </strong> ke rekening berikut:</p>
                                                <ul class="mb-1">
                                                    <li><strong>Bank BCA Digital</strong></li>
                                                    <li>No. Rekening: <strong>0900-12011708</strong></li>
                                                    <li>A.N: <strong>Ahmad Reza Rizky Setio Aji</strong></li>
                                                </ul>
                                                <p class="mb-0">Setelah melakukan Pelunasan, silakan tunggu konfirmasi dari Admin.</p>

                                            @else
                                                <h6 class="mb-1"><strong><i class="fas fa-fw fa-credit-card"></i> Informasi Pembayaran</strong></h6>
                                                <p class="mb-1">Silakan lakukan pembayaran <strong>DP minimal 50%</strong> dari total harga paket ke rekening berikut:</p>
                                                <ul class="mb-1">
                                                    <li><strong>Bank BCA Digital</strong></li>
                                                    <li>No. Rekening: <strong>0900-12011708</strong></li>
                                                    <li>A.N: <strong>Ahmad Reza Rizky Setio Aji</strong></li>
                                                </ul>
                                                <p class="mb-0">Setelah melakukan transfer, silakan unggah bukti pembayaran DP di bawah ini.</p>
                                            @endif

                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="nominal" class="col-form-label">Nominal</label>
                                            <input 
                                                type="text" 
                                                capture="environment" 
                                                {{-- value="{{ old('nominal', number_format($item->nominal ?? 0, 0, ',', '.')) }}"  --}}
                                                name="nominal" 
                                                class="form-control @error('nominal') is-invalid @enderror" 
                                                id="nominal" 
                                                oninput="formatNumberr(this)"
                                                autocomplete="off">
                                            @error('nominal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="jenis_pembayaran{{ $item->id_booking }}" class="col-form-label">Jenis Pembayaran</label>
                                            <select required id="jenis_pembayaran{{ $item->id_booking }}" class="form-control @error('jenis_pembayaran') is-invalid @enderror" name="jenis_pembayaran" id="jenis_pembayaran">
                                                <option value="">-- Pilih Jenis Pembayaran --</option>
                                                <option value="DP">DP</option>
                                                <option value="Pelunasan">Pelunasan</option>
                                            </select>
                                            @error('jenis_pembayaran')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="file_dp">Upload Bukti</label>
                                            <input 
                                                type="file" 
                                                name="file" 
                                                required
                                                id="file" 
                                                class="form-control @error('file') is-invalid @enderror">
                                            {{-- @if($item->file_dp)
                                                <small class="form-text text-muted">
                                                    File DP saat ini: 
                                                    <a target="_blank" target="_blank" href="{{ asset('storage/' . $item->file_dp) }}">Lihat DP</a>.
                                                    Biarkan kosong jika tidak ingin mengganti.
                                                </small>
                                            @endif --}}
                                            @error('file')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    
                                        @if ($item->file_dp)
                                            <img src="{{ asset('storage/' . $item->file_dp) }}" class="card-img-top mt-2" alt="Bukti DP">
                                            <p>Bukti DP</p>
                                        @else
                                            <p class="text-muted mt-2">Bukti DP tidak ditemukan!</p>
                                        @endif
                                        <hr>
                                        @if ($item->pesanan?->file_pelunasan)
                                            <img src="{{ asset('storage/' . $item->pesanan?->file_pelunasan) }}" class="card-img-top mt-2" alt="Bukti Pelunasan">
                                            <p>Bukti Pelunasan</p>
                                        @elseif ($item->file_pelunasan)
                                            <img src="{{ asset('storage/' . $item->file_pelunasan) }}" class="card-img-top mt-2" alt="Bukti Pelunasan">
                                            <p>Bukti Pelunasan</p>
                                        @else
                                            <p class="text-muted mt-2">Bukti Pelunasan tidak ditemukan!</p>
                                        @endif
                                    </div>
                                    
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary submitFormBtn" data-id="{{ $item->id_booking }}">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Modal file Pelunasan -->
                    <form action="{{ route('client.add.pelunasan',$item->id_booking) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal fade" id="modalPelunasan{{ $item->id_booking }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel{{ $item->id_booking }}">Pelunasan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @if ($item->pesanan)
                                            <div class="alert alert-info">
                                                <h6 class="mb-1"><strong><i class="fas fa-fw fa-credit-card"></i> Informasi Pelunasan</strong></h6>
                                                <!-- Tombol Cepitir -->
                                                <a
                                                    href="{{ route('client.export.faktur',$item->pesanan?->id_pesanan) }}" download style="text-decoration: underline;"><i class="fas fa-fw fa-file"></i>Download Faktur
                                                </a>
                                                <p class="mb-1">Silakan lakukan Pelunasan dari kekurangan: <strong>{{ 'Rp. ' . number_format($item->pesanan->kekurangan, 0, ',', '.') ?? '-' }} </strong> ke rekening berikut:</p>
                                                <ul class="mb-1">
                                                    <li><strong>Bank BCA Digital</strong></li>
                                                    <li>No. Rekening: <strong>0900-12011708</strong></li>
                                                    <li>A.N: <strong>Ahmad Reza Rizky Setio Aji</strong></li>
                                                </ul>
                                                <p class="mb-0">Setelah melakukan Pelunasan, silakan tunggu konfirmasi dari Admin.</p>
                                            </div>
                                            
                                        @endif
                                        <div class="form-group">
                                            <label for="pelunasan" class="col-form-label">Jumlah Pelunasan</label>
                                            <input id="pelunasan" 
                                            oninput="formatNumberr(this)" 
                                            type="text" 
                                            value="{{ old('pelunasan',number_format($item->pesanan?->pelunasan ?? 0, 0, ',', '.')) }}" name="pelunasan" min="0" class="form-control @error('pelunasan') is-invalid @enderror" id="pelunasan">
                                            @error('pelunasan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="file_dp">Upload Bukti Pelunasan </label>
                                            <input 
                                                type="file" 
                                                name="file_pelunasan" 
                                                id="file_pelunasan" 
                                                class="form-control @error('file_pelunasan') is-invalid @enderror">
                                            @if($item->pesanan?->file_pelunasan)
                                                <small class="form-text text-muted">
                                                    File Pelunasan saat ini: 
                                                    <a target="_blank" href="{{ asset('storage/' . $item->pesanan->file_pelunasan) }}">Lihat DP</a>.
                                                    Biarkan kosong jika tidak ingin mengganti.
                                                </small>
                                            @endif
                                            @error('file_pelunasan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        @if ($item->pesanan?->file_pelunasan)
                                            <img src="{{ asset('storage/' . $item->pesanan?->file_pelunasan) }}" class="card-img-top mt-2" alt="Bukti DP">
                                        @else
                                            <p class="text-muted mt-2">Bukti Pelunasan tidak ditemukan!</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                
                    <!-- Modal pilih edit foto -->
                    <div class="modal fade" id="modalEditFoto{{ $item->id_booking }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel{{ $item->id_booking }}">Hasil Foto</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('client.add.list.foto',$item->id_booking) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="link" class="col-form-label">Link Foto</label>
                                            <a target="_blank" href="{{ $item->pesanan?->foto?->link ? $item?->pesanan->foto->link : 'Link Belum Tersedia.' }}" name="link" readonly id="link" class="form-control @error('link') is-invalid @enderror">{{ $item->pesanan?->foto?->link ? $item?->pesanan->foto->link : 'Link Belum Tersedia.' }}</a>
                                            @error('link')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="kp_id" class="col-form-label">Pilih foto yang akan diedit</label>
                                            <select class="form-control js-example-tokenizer"
                                                {{ $item->pesanan?->foto?->status_foto == 'Editing' || $item->pesanan?->foto?->status_foto == 'Complete' ? 'disabled' : '' }} 
                                                style="width: 100%; height: 300px;" 
                                                multiple="multiple" name="foto_edit[]">
                                                @if ($item->pesanan?->foto?->foto_edit)
                                                    @php
                                                        $potoEdit = json_decode($item->pesanan->foto->foto_edit ?? '[]'); // fallback ke array kosong
                                                    @endphp
                                                    
                                                    @if (is_iterable($potoEdit))
                                                        @foreach ($potoEdit as $ft)
                                                            <option value="{{ $ft }}" selected>{{ $ft }}</option>
                                                        @endforeach
                                                    @endif

                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        @if ($item->pesanan?->foto?->status_foto == 'Editing' || $item->pesanan?->foto?->status_foto == 'Complete')
                                        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                                        @else
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal{{ $item->id_booking }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel{{ $item->id_booking }}">Detail Booking</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>Nama:</strong> {{ $item->nama ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Email:</strong> {{ $item->email ?? '-' }}</li>
                                        <li class="list-group-item"><strong>No. WA:</strong> {{ $item->no_wa ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Instagram Client:</strong> {{ $item->ig_client ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Paket:</strong> {{ $item->harga_paket?->paket->kategori_paket->nama_kategori . ' ' . $item->harga_paket?->paket->nama_paket ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Universitas:</strong> {{ $item->universitas ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Fakultas:</strong> {{ $item->fakultas ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Tanggal:</strong> {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</li>
                                        <li class="list-group-item"><strong>Jam:</strong> {{ $item->jam ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Lokasi Foto:</strong> {{ $item->lokasi_foto ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Harga Paket:</strong> {{ 'Rp ' . number_format($item->harga_paket?->harga, 0, ',', '.') ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Paket Tambahan:</strong>
                                            @php
                                                $paket_tambahan = [];
                                                $hargaPaketTambahan = 0;
                                                if ( $item->paketTambahan) {
                                                    foreach ($item->paketTambahan as $pt) {
                                                        $paket_tambahan[] = $pt->jenis_tambahan;
                                                        $hargaPaketTambahan += $pt->harga_tambahan;
                                                    }
                                                }
                                            @endphp
                                            {{ !empty($paket_tambahan) ? implode(', ', $paket_tambahan) : '-' }}
                                        </li>
                                        <li class="list-group-item"><strong>Harga Paket Tambahan:</strong> {{ 'Rp ' . number_format($item->pesanan?->harga_paket_tambahan, 0, ',', '.') ?? '-' }}</li>
                                        <li class="list-group-item"><strong>DP:</strong> {{ 'Rp ' . number_format($item->dp, 0, ',', '.') ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Jumlah Anggota:</strong> {{ $item->jumlah_anggota ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Catatan:</strong> {{ $item->req_khusus ?? '-' }}</li>
                                        <li class="list-group-item"><strong>IG Vendor MUA:</strong> {{ $item->ig_mua ?? '-' }}</li>
                                        <li class="list-group-item"><strong>IG Vendor Kebaya/Jass:</strong> {{ $item->ig_dress ?? '-' }}</li>
                                        <li class="list-group-item"><strong>IG Vendor Nailart:</strong> {{ $item->ig_nailart ?? '-' }}</li>
                                        <li class="list-group-item"><strong>IG Vendor Hijabdo/Hairdo:</strong> {{ $item->ig_hijab ?? '-' }}</li>
                                        <li class="list-group-item"><strong>Post Foto:</strong> {{ $item->post_foto ?? '-' }}</li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Pilih semua tombol dengan kelas delete-btn
                        document.querySelectorAll('.delete-btn').forEach(button => {
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

                        // Pilih semua tombol dengan kelas cancel-btn
                        document.querySelectorAll('.cancel-btn').forEach(button => {
                            button.addEventListener('click', function (e) {
                                e.preventDefault(); // Mencegah pengiriman form langsung
                    
                                const form = this.closest('form'); // Ambil form terdekat dari tombol yang diklik
                    
                                Swal.fire({
                                    title: 'Apakah booking ini akan di cancel?',
                                    // text: "Data yang dihapus tidak dapat dikembalikan!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Ya, Cancel',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        form.submit(); // Kirim form jika pengguna mengonfirmasi
                                    }
                                });
                            });
                        });
                    </script>

                    @include('client.booking.modal',['item' => $item])
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // $(document).ready(function() {
            $(".js-example-tokenizer").select2({
                tags: true,                 // Mengizinkan input custom
                allowClear: true,           // Mengizinkan penghapusan semua pilihan
                placeholder: "-- Pilih Foto --", // Placeholder untuk dropdown
                // maximumSelectionLength: 2,
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
        // });
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
    function formatNumberr(input) {
        // Menghapus semua karakter selain angka
        let value = input.value.replace(/\D/g, '');
    
        // Menambahkan titik setiap 3 digit
        let formattedValue = new Intl.NumberFormat('id-ID').format(value);
    
        // Mengatur kembali nilai input
        input.value = formattedValue;
    }
</script>


{{-- sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('berhasil'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        html: `
            <div class="alert alert-info" style="text-align: left;>
                <h6 class="mb-1"><strong><i class="fas fa-fw fa-credit-card"></i> Informasi Pembayaran</strong></h6>
                <p class="mb-1">Silakan lakukan pembayaran <strong>DP minimal 50%</strong> dari total harga paket ke rekening berikut:</p>
                <ul class="mb-1">
                    <li style="text-align: left;"><strong>Bank BCA Digital</strong></li>
                    <li style="text-align: left;">No. Rekening: <strong>0900-12011708</strong></li>
                    <li style="text-align: left;">A.N: <strong>Ahmad Reza Rizky Setio Aji</strong></li>
                </ul>
                <p class="mb-0">Setelah melakukan transfer, silakan unggah bukti pembayaran di Menu <strong>Pembayaran</strong>.</p>
            </div>
        `,
        icon: 'success',
        confirmButtonText: 'Oke',
        width: 600
    });
</script>
@endif


<script>
    document.querySelectorAll('.submitFormBtn').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;
        // let no_wa = document.getElementById(`no_wa${id}`).value.trim();
        let no_wa = '085156272866';
        let message = '';
        const jenisPembayaran = document.getElementById(`jenis_pembayaran${id}`).value;
        // Hapus karakter non-digit
        no_wa = no_wa.replace(/\D/g, '');

        // Convert jika diawali dengan '08'
        if (no_wa.startsWith('08')) {
            no_wa = '62' + no_wa.slice(1);
        }

        if (jenisPembayaran === 'DP') {
message = `Hi kak, aku sudah isi form dan Payment, tolong di cek ulang dan Accept ya kak, Terimakasih`.trim();
        } else if (jenisPembayaran === 'Pelunasan') {
message = `Kak, aku sudah payment untuk kekurangannya. Silahkan di check kembali yah kak, untuk fotonya aku tunggu versi originalnya, Terimakasih`.trim();
        }

        if (message !== '' && no_wa !== '') {
            const encodedMessage = encodeURIComponent(message);
            const whatsappUrl = `https://wa.me/${no_wa}?text=${encodedMessage}`;
            window.open(whatsappUrl, '_blank');
        }

        // Submit form
        document.getElementById(`pembayaranForm${id}`).submit();
    });
});
</script>

@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection
