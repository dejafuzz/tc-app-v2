@extends('layouts.master')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">KELOLA WILAYAH</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Wilayah</h6>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-solid fa-folder-plus fa-sm text-white-50"></i> Tambah Wilayah
            </button>
        </div>

        {{-- TAMBAH --}}
        <div class="modal fade" id="modalTambah" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Wilayah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.store.wilayah') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_wilayah" class="col-form-label">Nama Wilayah</label>
                                <input type="text" name="nama_wilayah" class="form-control" id="nama_wilayah" value="{{ old('nama_wilayah') }}">
                                @error('nama_wilayah')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="golongan" class="col-form-label">Golongan</label>
                                <select id="inputState" name="golongan" class="form-control">
                                    <option value="">-- Pilih Wilayah --</option>
                                    <option value="W1" {{ old('golongan') == 'W1' ? 'selected' : '' }}>Wilayah 1</option>
                                    <option value="W2" {{ old('golongan') == 'W2' ? 'selected' : '' }}>Wilayah 2</option>
                                    <option value="W3" {{ old('golongan') == 'W3' ? 'selected' : '' }}>Wilayah 3</option>
                                    <option value="W4" {{ old('golongan') == 'W4' ? 'selected' : '' }}>Wilayah 4</option>
                                </select>
                                @error('golongan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            {{-- <div class="form-group">
                                <label for="harga" class="col-form-label">Harga</label>
                                <input type="text" name="harga" class="form-control" id="harga" value="{{ old('harga') }}">
                                @error('harga')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">NO</th>
                            <th class="text-center">NAMA WILAYAH</th>
                            <th class="text-center">GOLONGAN</th>
                            {{-- <th class="text-center">HARGA</th> --}}
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wilayah as $item)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->nama_wilayah }}</td>
                                <td class="text-center">{{ $item->kode }}</td>
                                {{-- <td>{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td> --}}
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_wilayah }}" title="Update">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </a>
                                            <form action="{{ route('admin.delete.wilayah',['id' => $item->id_wilayah]) }}" method="POST" class="delete-form">
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
                                {{-- @include('admin.wilayah.modal', ['item' => $item]) --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($wilayah as $item)
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
                                    <option value="W3" {{ old('golongan', $item->kode) == 'W3' ? 'selected' : '' }}>Wilayah 3</option>
                                    <option value="W4" {{ old('golongan', $item->kode) == 'W4' ? 'selected' : '' }}>Wilayah 4</option>
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
    @endforeach
@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection