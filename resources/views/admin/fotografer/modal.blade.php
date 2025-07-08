
{{-- EDIT --}}
<div class="modal fade" id="modalEdit{{ $item->id_fotografer }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Fotografer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.update.fotografer', ['id' => $item->id_fotografer]) }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                        <div class="form-group">
                            <label for="nama" class="col-form-label">Nama</label>
                            <input 
                                type="text" 
                                name="nama" 
                                class="form-control @error('nama') is-invalid @enderror" 
                                id="nama" 
                                value="{{ old('nama', $item->nama) }}" 
                                placeholder="Masukkan Nama">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_wa" class="col-form-label">No WA</label>
                            <input 
                                type="text" 
                                name="no_wa" 
                                class="form-control @error('no_wa') is-invalid @enderror" 
                                id="no_wa" 
                                value="{{ old('no_wa', $item->no_wa) }}" 
                                placeholder="Masukkan No WA">
                            @error('no_wa')
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