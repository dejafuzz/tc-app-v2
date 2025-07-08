{{-- TAMBAH --}}
<form action="{{ route('admin.store.booking') }}" method="POST">
    @csrf
    <div class="modal fade" id="modalTambah" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- Kiri --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="col-form-label">Nama</label>
                                <input type="text" placeholder="Masukkan nama" value="{{ old('nama') }}" name="nama" class="form-control @error('nama') is-invalid @enderror">
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email</label>
                                <input type="email" placeholder="Masukkan email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="no_wa" class="col-form-label">WhatsApp</label>
                                <input type="text" placeholder="Masukkan nomor WhatsApp" value="{{ old('no_wa') }}" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror">
                                @error('no_wa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="event" class="col-form-label">Event</label>
                                <input type="text" placeholder="Masukkan nama event" value="{{ old('event') }}" name="event" class="form-control @error('event') is-invalid @enderror">
                                @error('event')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="tanggal" class="col-form-label">Tanggal</label>
                                <input type="date" value="{{ old('tanggal') }}" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror">
                                @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="jam" class="col-form-label">Jam</label>
                                <input type="time" value="{{ old('jam') }}" name="jam" class="form-control @error('jam') is-invalid @enderror">
                                @error('jam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Kanan --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="universitas" class="col-form-label">Universitas</label>
                                <input type="text" placeholder="Masukkan nama universitas" value="{{ old('universitas') }}" name="universitas" class="form-control @error('universitas') is-invalid @enderror">
                                @error('universitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="fakultas" class="col-form-label">Fakultas</label>
                                <input type="text" placeholder="Masukkan nama fakultas" value="{{ old('fakultas') }}" name="fakultas" class="form-control @error('fakultas') is-invalid @enderror">
                                @error('fakultas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="lokasi_foto" class="col-form-label">Lokasi Foto</label>
                                <input type="text" placeholder="Masukkan lokasi foto" value="{{ old('lokasi_foto') }}" name="lokasi_foto" class="form-control @error('lokasi_foto') is-invalid @enderror">
                                @error('lokasi_foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="ig_client" class="col-form-label">IG Client</label>
                                <input type="text" placeholder="Masukkan Instagram client" value="{{ old('ig_client') }}" name="ig_client" class="form-control @error('ig_client') is-invalid @enderror">
                                @error('ig_client')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="jumlah_anggota" class="col-form-label">Jumlah Anggota</label>
                                <input type="text" placeholder="Masukkan jumlah anggota" value="{{ old('jumlah_anggota') }}" name="jumlah_anggota" class="form-control @error('jumlah_anggota') is-invalid @enderror">
                                @error('jumlah_anggota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="post_foto" class="col-form-label">Post Foto</label>
                                <select id="post_foto" name="post_foto" class="form-control @error('post_foto') is-invalid @enderror">
                                    <option selected disabled value="">--Pilih--</option>
                                    <option value="Bersedia" {{ old('post_foto') == 'Bersedia' ? 'selected' : '' }}>Bersedia</option>
                                    <option value="Tidak Bersedia" {{ old('post_foto') == 'Tidak Bersedia' ? 'selected' : '' }}>Tidak Bersedia</option>
                                </select>
                                @error('post_foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kota" class="col-form-label">Kota/Kabupaten</label>
                        <input type="text" value="{{ old('kota') }}" name="kota" class="form-control @error('kota') is-invalid @enderror" id="kota">
                        @error('kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga_paket_id" class="col-form-label">Paket</label>
                        <select id="harga_paket_id" name="harga_paket_id" class="form-control js-example-basic-single @error('harga_paket_id') is-invalid @enderror">
                            <option selected disabled value="">--Pilih Paket--</option>
                            @foreach ($hargaPaket as $harga)
                                <option value="{{ $harga->id_harga_paket }}" {{ old('harga_paket_id') == $harga->id_harga_paket ? 'selected' : '' }}>
                                    {{ $harga->paket->kategori_paket->nama_kategori . ' ' . $harga->paket->nama_paket . ' | ' }}
                                    @php
                                        $namaWilayah = \App\Models\Wilayah::where('kode', $harga->golongan)->pluck('nama_wilayah')->toArray();
                                    @endphp
                                    {{ implode(', ', $namaWilayah) }}
                                </option>
                            @endforeach
                        </select>
                        @error('harga_paket_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                    {{-- Catatan (full width) --}}
                    <div class="form-group">
                        <label for="req_khusus" class="col-form-label">Catatan</label>
                        <textarea name="req_khusus" class="form-control @error('req_khusus') is-invalid @enderror" id="req_khusus" rows="3" placeholder="Masukkan catatan tambahan">{{ old('req_khusus') }}</textarea>
                        @error('req_khusus')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</form>