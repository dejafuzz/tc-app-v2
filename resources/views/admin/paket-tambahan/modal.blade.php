{{-- EDIT --}}
<div class="modal fade" id="modalEdit{{ $item->id_paket_tambahan }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Paket Tambahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.update.paket-tambahan',$item->id_paket_tambahan) }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis_tambahan" class="col-form-label">Jenis Tambahan</label>
                        <input type="text" value="{{ old('jenis_tambahan',$item->jenis_tambahan) }}" name="jenis_tambahan" class="form-control @error('jenis_tambahan') is-invalid @enderror" id="jenis_tambahan">
                        @error('jenis_tambahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label for="harga_tambahan" class="col-form-label">Harga</label>
                        <input type="number" value="{{ old('harga_tambahan',$item->harga_tambahan) }}" name="harga_tambahan" class="form-control @error('harga_tambahan') is-invalid @enderror" id="harga_tambahan">
                        @error('harga_tambahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>