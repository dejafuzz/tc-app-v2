{{-- EDIT --}}
<div class="modal fade" id="modalEdit{{ $item->id_wilayah }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Wilayah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.update.wilayah', ['id' => $item->id_wilayah]) }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_wilayah" class="col-form-label">Nama Wilayah</label>
                        <input type="text" name="nama_wilayah" class="form-control" id="nama_wilayah" value="{{ old('nama_wilayah', $item->nama_wilayah) }}">
                        @error('nama_wilayah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="golongan" class="col-form-label">Golongan</label>
                        <select id="inputState" name="golongan" class="form-control">
                            <option value="W1" {{ old('golongan', $item->kode) == 'W1' ? 'selected' : '' }}>Wilayah 1</option>
                            <option value="W2" {{ old('golongan', $item->kode) == 'W2' ? 'selected' : '' }}>Wilayah 2</option>
                        </select>
                        @error('golongan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
                    {{-- <div class="form-group">
                        <label for="harga" class="col-form-label">Harga</label>
                        <input type="text" name="harga" class="form-control" id="harga" value="{{ old('harga', $item->harga) }}">
                        @error('harga')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>