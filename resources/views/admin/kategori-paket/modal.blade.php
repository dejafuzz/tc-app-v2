{{-- EDIT --}}
<div class="modal fade" id="modalEdit{{ $item->id_kp }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Kategori Paket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.update.kategori-paket', ['id' => $item->id_kp]) }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_kategori" class="col-form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $item->nama_kategori) }}" class="form-control" id="nama_kategori">
                        </div>
                        @error('nama_kategori')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>