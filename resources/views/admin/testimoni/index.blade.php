@extends('layouts.master')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">KELOLA TESTIMONI</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Testimoni</h6>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-solid fa-comments fa-sm text-white-50"></i> Tambah Testimoni
            </button>
        </div>

        

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">NO</th>
                            <th class="text-center">NAMA</th>
                            <th class="text-center">EVENT</th>
                            <th class="text-center">DESKRIPSI</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimoni as $item)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->event }}</td>
                                <td class="text-center">{{ $item->deskripsi }}</td>
                                <td class="text-center">
                                    @if ($item->status == 'Pending')
                                        <span class="badge badge-info">{{ $item->status }}</span>
                                    @else
                                        <span class="badge badge-success">{{ $item->status }}</span>
                                    @endif
                                </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_testimoni }}" title="Update">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </a>
                                            <form action="{{ route('admin.delete.testi',['id' => $item->id_testimoni]) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-circle btn-sm delete-btn mr-2" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                {{-- SweetAlert Delete --}}
                                <script>
                                    // Pilih semua tombol dengan kelas delete-btn
                                    document.querySelectorAll('.delete-btn').forEach(button => {
                                        button.addEventListener('click', function (e) {
                                            e.preventDefault(); // Mencegah pengiriman form langsung
                                
                                            const form = this.closest('form'); // Ambil form terdekat dari tombol yang diklik
                                
                                            Swal.fire({
                                                title: 'Apakah data ini akan dihapus?',
                                                text: "Data yang dihapus tidak dapat dikembalikan!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Ya, hapus!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    form.submit(); // Kirim form jika pengguna mengonfirmasi
                                                }
                                            });
                                        });
                                    });
                                </script>
                                {{-- @include('admin.testimoni.modal', ['item' => $item]) --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($testimoni as $item)
        {{-- TAMBAH --}}
        <div class="modal fade" id="modalTambah" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Testimoni</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.store.testi') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama" class="col-form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama') }}">
                                @error('nama')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="event" class="col-form-label">Event</label>
                                <input type="text" name="event" class="form-control" id="event" value="{{ old('event') }}">
                                @error('event')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="deskripsi" class="col-form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" rows="3" placeholder="Masukkan catatan tambahan">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="status" class="col-form-label">Status</label>
                                <select id="inputState" name="status" class="form-control">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Posted" {{ old('status') == 'Posted' ? 'selected' : '' }}>Posted</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- EDIT --}}
        <form action="{{ route('admin.update.testi', ['id' => $item->id_testimoni]) }}" method="POST">
        @csrf
        @method('put')
            <div class="modal fade" id="modalEdit{{ $item->id_testimoni }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Testimoni</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                            <div class="modal-body">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nama" class="col-form-label">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama',$item->nama) }}">
                                        @error('nama')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="event" class="col-form-label">Event</label>
                                        <input type="text" name="event" class="form-control" id="event" value="{{ old('event',$item->event) }}">
                                        @error('event')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="deskripsi" class="col-form-label">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" rows="3" placeholder="Masukkan catatan tambahan">{{ old('deskripsi',$item->deskripsi) }}</textarea>
                                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="status" class="col-form-label">Status</label>
                                        <select id="inputState" name="status" class="form-control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="Pending" {{ old('status',$item->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Posted" {{ old('status',$item->status) == 'Posted' ? 'selected' : '' }}>Posted</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection