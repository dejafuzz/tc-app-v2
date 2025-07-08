

{{-- EDIT --}}
<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.update.users', ['id' => $item->id]) }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nama</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name', $item->name) }}" 
                            placeholder="Masukkan Nama">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email', $item->email) }}" 
                            placeholder="Masukkan Email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role_id" class="col-form-label">Sebagai</label>
                        <select 
                            id="inputState" 
                            name="role_id" 
                            class="form-control @error('role_id') is-invalid @enderror">
                            <option value="">-- Pilih Role --</option>
                            @foreach ($role as $rol)
                                <option 
                                    value="{{ $rol->id_role }}" 
                                    {{ old('role_id', $item->role_id) == $rol->id_role ? 'selected' : '' }}>
                                    {{ $rol->level }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"" id="password">
                        <span style="color:red">*kosongi jika tidak ingin mengganti password</span>
                        @error('password')
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
<div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-labelledby="DetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="userName" class="form-label">Nama: {{ $item->name }}</label>
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label">Email: {{ $item->email }}</label>
                </div>
                <div class="mb-3">
                    <label for="userLevel" class="form-label">Level: {{ $item->role->level }}</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>