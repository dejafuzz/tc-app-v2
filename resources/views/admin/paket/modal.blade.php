{{-- EDIT --}}
<div class="modal fade" id="modalEdit{{ $item->id_paket }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Paket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.update.paket', ['id' => $item->id_paket]) }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kp_id" class="col-form-label">Kategori Paket</label>
                        <select id="inputState" name="kp_id" class="form-control @error('kp_id') is-invalid @enderror">
                            <option>-- Pilih Kategori Paket --</option>
                            @foreach ($kp as $k)
                                <option value="{{ $k->id_kp }}" {{ old('kp_id',$item->kp_id) == $item->kp_id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kp_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_paket" class="col-form-label">Nama Paket</label>
                        <input 
                            type="text" 
                            name="nama_paket" 
                            class="form-control @error('nama_paket') is-invalid @enderror" 
                            id="nama_paket" 
                            value="{{ old('nama_paket',$item->nama_paket) }}" 
                            placeholder="Masukkan Nama Paket">
                        @error('nama_paket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kp_id" class="col-form-label">Fitur</label>
                        <select class="form-control js-example-tokenizer" style="width: 100%; height: 300px;" multiple="multiple" name="fitur[]">
                            @foreach ($fiturs as $fitur)
                                <option value="{{ $fitur }}" selected>{{ $fitur }}</option>
                            @endforeach
                        </select>
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