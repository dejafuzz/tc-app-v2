{{-- EDIT --}}
<div class="modal fade" id="modalEdit{{ $item->id_harga_paket }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Harga Paket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.update.harga-paket', $item->id_harga_paket) }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    {{-- <div class="form-group">
                        <label for="paket_id" class="col-form-label">Nama Paket</label>
                        <select id="inputState" name="paket_id" class="form-control @error('paket_id') is-invalid @enderror">
                            <option selected disabled value="">-- Pilih Paket --</option>
                            @foreach ($paket as $p)
                                <option value="{{ $p->id_paket }}" {{ old('paket_id',$item->paket_id) == $p->id_paket ? 'selected' : '' }}>{{ $p->kategori_paket->nama_kategori . ' ' . $p->nama_paket }}</option>
                            @endforeach
                        </select>
                        @error('paket_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="golongan" class="col-form-label">Golongan Wilayah</label>
                        <select id="inputState" name="golongan" class="form-control @error('golongan') is-invalid @enderror">
                            <option selected disabled value="">-- Pilih --</option>
                            <option value="W1" {{ old('golongan',$item->golongan) == 'W1' ? 'selected' : '' }}>Wilayah 1</option>
                            <option value="W2" {{ old('golongan',$item->golongan) == 'W2' ? 'selected' : '' }}>Wilayah 2</option>
                        </select>
                        @error('golongan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="form-group">
                        <label for="harga" class="col-form-label">Harga Paket</label>
                        <input type="number" value="{{ old('harga',$item->harga) }}" min="1" name="harga" class="form-control @error('harga') is-invalid @enderror" id="harga">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

{{-- DETAIL --}}
<div class="modal fade" id="modalDetail{{ $item->id_harga_paket }}" tabindex="-1" aria-labelledby="DetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Harga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="userName" class="form-label">Nama Paket: {{ $item->paket->kategori_paket->nama_kategori . ' ' . $item->paket->nama_paket }}</label>
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label">Fitur: 
                        @php
                            $fiturs = json_decode($item->paket->fitur);
                        @endphp
                        @foreach ($fiturs as $fitur)
                            <li>{{ $fitur }}</li>
                        @endforeach
                    </label>
                </div>
                @php
                    $cekWil = \App\Models\Wilayah::where('kode',$item->golongan)->get();
                    // dd($cekWil);
                @endphp
                <div class="mb-3">
                    <label for="userLevel" class="form-label">Harga: 
                        <li>{{ 'Rp. ' . number_format($item->harga, 0, ',', '.') }} (
                            @foreach ($cekWil as $wil)
                                {{ $wil->nama_wilayah . ',' }}
                            @endforeach
                            )
                        </li>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>