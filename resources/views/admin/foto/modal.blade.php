{{-- LINK --}}
<div class="modal fade" id="modalLink{{ $item->id_foto }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Link Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="nama_wilayah" class="col-form-label">Link</label>
                        <textarea name="link" class="form-control @error('link') is-invalid @enderror" id="link" rows="3">{{ old('link',$item->link ?? '-') }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- EDIT --}}
<div class="modal fade" id="modalEdit{{ $item->id_foto }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.update.foto',$item->id_foto) }}" method="post">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status_foto" class="col-form-label">Status Foto</label>
                        <select id="inputState" name="status_foto" class="form-control">
                            <option value="">-- Pilih Status Foto --</option>
                            <option value="Sending" {{ old('status_foto', $item->status_foto) == 'Sending' ? 'selected' : '' }}>Sending</option>
                            <option value="Listing" {{ old('status_foto', $item->status_foto) == 'Listing' ? 'selected' : '' }}>Listing</option>
                            <option value="Editing" {{ old('status_foto', $item->status_foto) == 'Editing' ? 'selected' : '' }}>Editing</option>
                            <option value="Complete" {{ old('status_foto', $item->status_foto) == 'Complete' ? 'selected' : '' }}>Complete</option>
                        </select>
                        @error('status_foto')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="link" class="col-form-label">Link Foto</label>
                        <textarea name="link" id="link" class="form-control @error('link') is-invalid @enderror">{{ old('link',$item->link) }}</textarea>
                        @error('link')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="list_foto">List Foto Edit</label>
                        @php
                            $fotoEdit = json_decode($item->foto_edit);
                            // dd($fotoEdit);
                        @endphp
                        @if ($item->foto_edit)
                            <ul class="list-group">
                                @foreach ($fotoEdit as $list)
                                    <li class="list-group-item">{{ $list }}</li>
                                @endforeach
                            </ul>
                        @endif
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