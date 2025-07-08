{{-- EDIT --}}
<form id="lengkapiDataForm" action="{{ route('client.update.booking',$item->id_booking) }}" method="POST">
    @csrf
    @method('put')
    <div class="modal fade" id="modalEdit{{ $item->id_booking }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Lengkapi Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="col-form-label">Nama <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        name="nama" 
                                        id="nama" 
                                        class="form-control @error('nama') is-invalid @enderror" 
                                        value="{{ old('nama', $item->nama ?? '') }}" 
                                        required 
                                        autocomplete="off">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" value="{{ old('email',$item->email) }}" name="email" class="form-control @error('email') is-invalid @enderror" id="email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_wa" class="col-form-label">No. WA <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('no_wa',$item->no_wa) }}" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror" id="no_wa">
                                    @error('no_wa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="event" class="col-form-label">Event <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('event',$item->event) }}" name="event" class="form-control @error('event') is-invalid @enderror" id="event">
                                    @error('event')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal" class="col-form-label">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" value="{{ old('tanggal',$item->tanggal) }}" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal">
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jam" class="col-form-label">Jam <span class="text-danger">*</span></label>
                                    <input type="time" value="{{ old('jam',$item->jam) }}" name="jam" class="form-control @error('jam') is-invalid @enderror" id="jam">
                                    @error('jam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="kota" class="col-form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('kota',$item->kota) }}" name="kota" class="form-control @error('kota') is-invalid @enderror" id="kota">
                                    @error('kota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="universitas" class="col-form-label">Universitas <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('universitas',$item->universitas) }}" name="universitas" class="form-control @error('universitas') is-invalid @enderror" id="universitas">
                                    @error('universitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="fakultas" class="col-form-label">Fakultas <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('fakultas',$item->fakultas) }}" name="fakultas" class="form-control @error('fakultas') is-invalid @enderror" id="fakultas">
                                    @error('fakultas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="lokasi_foto" class="col-form-label">Lokasi Foto <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('lokasi_foto',$item->lokasi_foto) }}" name="lokasi_foto" class="form-control @error('lokasi_foto') is-invalid @enderror" id="lokasi_foto">
                                    @error('lokasi_foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="ig_client" class="col-form-label">Instagram</label>
                                    <input type="text" value="{{ old('ig_client',$item->ig_client) }}" name="ig_client" class="form-control @error('ig_client') is-invalid @enderror" id="ig_client">
                                    @error('ig_client')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                <div class="form-group">
                                    <label for="jumlah_anggota" class="col-form-label">Jumlah Anggota <span class="text-danger">*</span></label>
                                    <input type="number" value="{{ old('jumlah_anggota',$item->jumlah_anggota) }}" name="jumlah_anggota" class="form-control @error('jumlah_anggota') is-invalid @enderror" id="jumlah_anggota">
                                    @error('jumlah_anggota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="harga_paket_id" class="col-form-label">Paket <span class="text-danger">*</span></label>
                                    <select id="harga_paket_id" name="harga_paket_id" data-id="{{ $item->id_booking }}" class="form-control js-example-basic-single-update @error('harga_paket_id') is-invalid @enderror">
                                        <option selected disabled value="">--Pilih Paket--</option>
                                        @foreach ($hargaPaket as $harga)
                                            <option value="{{ $harga->id_harga_paket }}" 
                                                {{ old('harga_paket_id', $item->harga_paket_id) == $harga->id_harga_paket ? 'selected' : '' }}>
                                                
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
                            </div>
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
                            <textarea name="req_khusus" class="form-control @error('req_khusus') is-invalid @enderror" placeholder="Masukkan catatan tambahan" id="req_khusus" rows="3">{{ old('req_khusus',$item->req_khusus) }}</textarea>
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