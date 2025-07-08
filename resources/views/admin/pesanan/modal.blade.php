{{-- EDIT --}}
<div class="modal fade" id="modalEdit{{ $item->id_pesanan }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Update Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.update.pesanan',$item->id_pesanan) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tanggal" class="col-form-label">Tanggal</label>
                            <input type="date" value="{{ old('tanggal', $item->booking->tanggal) }}" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="negara" class="col-form-label">Negara</label>
                            <input type="text" value="{{ old('negara', $item->booking->negara ?? 'Indonesia') }}" name="negara" class="form-control @error('negara') is-invalid @enderror" id="negara">
                            @error('negara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="kota" class="col-form-label">Kota</label>
                            <input type="text" value="{{ old('kota', $item->booking->kota) }}" name="kota" class="form-control @error('kota') is-invalid @enderror" id="kota">
                            @error('kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="universitas" class="col-form-label">Universitas</label>
                            <input type="text" value="{{ old('universitas', $item->booking->universitas) }}" name="universitas" class="form-control @error('universitas') is-invalid @enderror" id="universitas">
                            @error('universitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="nama" class="col-form-label">Nama</label>
                            <input type="text" value="{{ old('nama', $item->booking->nama) }}" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="jam" class="col-form-label">Jam</label>
                            <input type="time" value="{{ old('jam', $item->booking->jam) }}" name="jam" class="form-control @error('jam') is-invalid @enderror" id="jam">
                            @error('jam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="jam_selesai" class="col-form-label">Jam Selesai</label>
                            <input type="time" value="{{ old('jam_selesai',$item->booking->jam_selesai) }}" name="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" id="jam_selesai">
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-row">
                        {{-- <div class="form-group col-md-6">
                            <label for="kategori_paket" class="col-form-label">Kategori Paket</label>
                            <input type="text" value="{{ old('kategori_paket', $item->booking->harga_paket->paket->kategori_paket->nama_kategori . ' ' . $item->booking->harga_paket->paket->nama_paket) }}" name="kategori_paket" class="form-control @error('kategori_paket') is-invalid @enderror" id="kategori_paket">
                            @error('kategori_paket')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="form-group col-md-6">
                            <label for="harga_paket_id" class="col-form-label">Paket</label>
                            <select id="harga_paket_id" name="harga_paket_id" class="form-control @error('harga_paket_id') is-invalid @enderror">
                                <option selected disabled value="">--Pilih Paket--</option>
                                @foreach ($hargaPaket as $harga)
                                    <option value="{{ $harga->id_harga_paket }}" 
                                        {{ old('harga_paket_id', $item->booking->harga_paket->id_harga_paket) == $harga->id_harga_paket ? 'selected' : '' }}>
                                        
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
                    
                        <div class="form-group col-md-6">
                            <label for="fotografer_id" class="col-form-label">Fotografer</label>
                            <select id="inputState" name="fotografer_id" class="form-control @error('fotografer_id') is-invalid @enderror">
                                <option value="">-- Pilih Fotografer --</option>
                                @foreach ($fotografer as $fg)
                                    <option 
                                        value="{{ $fg->id_fotografer }}" 
                                        {{ old('fotografer_id', $item->fotografer_id) == $fg->id_fotografer ? 'selected' : '' }}>
                                        {{ $fg->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fotografer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fakultas" class="col-form-label">Fakultas</label>
                            <input type="text" value="{{ old('fakultas', $item->booking->fakultas) }}" name="fakultas" class="form-control @error('fakultas') is-invalid @enderror" id="fakultas">
                            @error('fakultas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="lokasi_foto" class="col-form-label">Lokasi Foto</label>
                            <input type="text" value="{{ old('lokasi_foto', $item->booking->lokasi_foto) }}" name="lokasi_foto" class="form-control @error('lokasi_foto') is-invalid @enderror" id="lokasi_foto">
                            @error('lokasi_foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="post_foto" class="col-form-label">Upload IG</label>
                            <select id="post_foto" name="post_foto" class="form-control @error('post_foto') is-invalid @enderror">
                                <option selected disabled value="">--Pilih--</option>
                                <option value="Bersedia" {{ old('post_foto',$item->booking->post_foto) == 'Bersedia' ? 'selected' : '' }}>Bersedia</option>
                                <option value="Tidak Bersedia" {{ old('post_foto',$item->booking->post_foto) == 'Tidak Bersedia' ? 'selected' : '' }}>Tidak Bersedia</option>
                            </select>
                            @error('post_foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="no_wa" class="col-form-label">No Wa</label>
                            <input type="text" value="{{ old('no_wa', $item->booking->no_wa) }}" min="1" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror" id="no_wa">
                            @error('no_wa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="keterangan" class="col-form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" rows="3">{{ old('keterangan',$item->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    @php
                        $jumlahHargaTambahan = $item->harga_paket_tambahan;
                        // foreach ($item->booking->paketTambahan as $pt) {
                        //     $jumlahHargaTambahan += $pt->harga_tambahan;
                        // }
                        $kekurangan = ($item->booking->harga_paket->harga + $jumlahHargaTambahan) - ($item->booking->dp + $item->pelunasan);
                        
                        $total = $item->booking->dp + $item->pelunasan;
                        
                    @endphp

                    <div class="form-group">
                        <label for="kp_id" class="col-form-label">Paket Tambahan</label>
                        <select class="form-control js-paket-tambahan" 
                            style="width: 100%; height: 300px;" disabled
                            multiple="multiple" name="paket_tambahan[]">
                            @foreach ($paketTambahan as $pt)
                                <option value="{{ $pt->id_paket_tambahan }}" 
                                    @if (isset($item->booking) && $item->booking->paketTambahan->contains('id_paket_tambahan', $pt->id_paket_tambahan)) selected @endif>
                                    {{ $pt->jenis_tambahan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="harga" class="col-form-label">Harga Paket</label>
                            <input 
                                type="text" 
                                value="{{ old('harga', number_format($item->booking->harga_paket->harga ?? 0, 0, ',', '.')) }}" 
                                name="harga" 
                                class="form-control @error('harga') is-invalid @enderror" 
                                id="harga" 
                                readonly
                                oninput="formatNumber(this)"
                                autocomplete="off">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="harga_paket_tambahan" class="col-form-label">Harga Paket Tambahan</label>
                            <input 
                                type="text" 
                                value="{{ old('harga_paket_tambahan', number_format($jumlahHargaTambahan ?? 0, 0, ',', '.')) }}" 
                                name="harga_paket_tambahan" 
                                class="form-control @error('harga_paket_tambahan') is-invalid @enderror" 
                                id="harga_paket_tambahan" 
                                oninput="formatNumber(this)"
                                autocomplete="off">
                            @error('harga_paket_tambahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="dp" class="col-form-label">DP</label>
                            <input 
                                type="text" 
                                value="{{ old('dp', number_format($item->booking->dp ?? 0, 0, ',', '.')) }}" 
                                name="dp" 
                                class="form-control @error('dp') is-invalid @enderror" 
                                id="dp" 
                                readonly
                                oninput="formatNumber(this)"
                                autocomplete="off">
                            @error('dp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="kekurangan" class="col-form-label">Kekurangan</label>
                            <input 
                                type="text" 
                                value="{{ old('kekurangan', number_format($item->kekurangan ?? 0, 0, ',', '.')) }}" 
                                name="kekurangan" 
                                class="form-control @error('kekurangan') is-invalid @enderror" 
                                id="kekurangan" 
                                readonly
                                oninput="formatNumber(this)"
                                autocomplete="off">
                            @error('kekurangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pelunasan" class="col-form-label">Pelunasan</label>
                            <input 
                                type="text" 
                                value="{{ old('pelunasan', number_format($item->pelunasan ?? 0, 0, ',', '.')) }}" 
                                name="pelunasan" 
                                class="form-control @error('pelunasan') is-invalid @enderror" 
                                id="pelunasan" 
                                oninput="formatNumber(this)"
                                autocomplete="off">
                            @error('pelunasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="discount" class="col-form-label">Discount</label>
                            <input 
                                type="text" 
                                value="{{ old('discount', number_format($item->discount ?? 0, 0, ',', '.')) }}" 
                                name="discount" 
                                class="form-control @error('discount') is-invalid @enderror" 
                                id="discount" 
                                oninput="formatNumber(this)"
                                autocomplete="off">
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="total" class="col-form-label">Total</label>
                            <input 
                                type="text" 
                                value="{{ old('total', number_format($item->total ?? 0, 0, ',', '.')) }}" 
                                name="total" 
                                class="form-control @error('total') is-invalid @enderror" 
                                id="total" 
                                readonly
                                oninput="formatNumber(this)"
                                autocomplete="off">
                            @error('total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="freelance" class="col-form-label">Freelance</label>
                            <input 
                                type="text" 
                                value="{{ old('freelance', number_format($item->freelance ?? 0, 0, ',', '.')) }}" 
                                name="freelance" 
                                class="form-control @error('freelance') is-invalid @enderror" 
                                id="freelance" 
                                readonly
                                oninput="formatNumber(this)"
                                autocomplete="off">
                            @error('freelance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="status_pembayaran" class="col-form-label">Status Pembayaran</label>
                            <select id="inputState" name="status_pembayaran" class="form-control">
                                <option value="">-- Pilih Status Pembayaran --</option>
                                <option value="Lunas" {{ old('status_pembayaran', $item->status_pembayaran) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="Belum Lunas" {{ old('status_pembayaran', $item->status_pembayaran) == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            </select>
                            @error('status_pembayaran')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

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