@extends('layouts.master')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">KELOLA FOTO LANDING</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Foto Landing</h6>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-solid fa-folder-plus fa-sm text-white-50"></i> Tambah Foto
            </button>
        </div>

        <style>
            .modal-body {
                max-height: 70vh;
                overflow-y: auto;
            }
        
            #preview_foto {
                max-width: 100%;
                height: auto;
                max-height: 200px;
                display: none;
                object-fit: contain;
            }
        </style>

        <div class="modal fade" id="modalTambah" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Foto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.store.foto.landing') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="univ" class="col-form-label">Universitas</label>
                                <input 
                                    type="text" 
                                    name="univ" 
                                    id="univ" 
                                    class="form-control @error('univ') is-invalid @enderror" 
                                    value="{{ old('univ') }}" 
                                    placeholder="Masukkan Universitas">
                                @error('univ')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="keterangan" class="col-form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="foto" class="col-form-label">Upload Foto</label>
                                <input 
                                    type="file" 
                                    name="foto" 
                                    class="form-control @error('foto') is-invalid @enderror" 
                                    id="foto" 
                                    accept="image/*">
                                <img id="preview_foto" class="img-thumbnail mt-2" style="display: none; max-width: 200px;">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
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

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">No</th>
                            <th class="text-center">UNIVERSITAS</th>
                            <th class="text-center">KETERANGAN</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($foto as $item)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->univ }}</td>
                                <td class="text-center">{{ $item->keterangan }}</td>
                                <td class="text-center">
                                    @if ($item->status == 'Pending')
                                        <span class="badge badge-info">{{ $item->status }}</span>
                                    @elseif ($item->status == 'Posted')
                                        <span class="badge badge-success">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-success btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalLihat{{ $item->id_foto_landing }}"  title="Detail">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_foto_landing }}" title="Update">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </a>
                                        <form action="{{ route('admin.delete.foto.landing', ['id' => $item->id_foto_landing]) }}" method="POST" class="delete-form">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($foto as $item)
        {{-- MODAL UPDATE FOTO LANDING --}}
        <div class="modal fade" id="modalEdit{{ $item->id_foto_landing }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Update Foto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.update.foto.landing', ['id' => $item->id_foto_landing]) }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="univ" class="col-form-label">Universitas</label>
                                <input 
                                    type="text" 
                                    name="univ" 
                                    id="univ" 
                                    class="form-control @error('univ') is-invalid @enderror" 
                                    value="{{ old('univ',$item->univ) }}" 
                                    placeholder="Masukkan Universitas">
                                @error('univ')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="keterangan" class="col-form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="">{{ old('keterangan',$item->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="paket">Status Foto</label>
                                <select class="form-control" name="status" id="paket">
                                    <option value="" selected>-- Pilih Status --</option>
                                    <option {{ $item->status == 'Pending' ? 'selected' : '' }} value="Pending">Pending</option>
                                    <option {{ $item->status == 'Posted' ? 'selected' : '' }} value="Posted">Posted</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="foto" class="col-form-label">Upload Foto</label>
                                <input 
                                    type="file" 
                                    name="foto" 
                                    class="form-control @error('foto') is-invalid @enderror" 
                                    id="foto" 
                                    accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($item->foto)
                                    <small class="form-text text-muted">
                                        Foto saat ini: 
                                    </small>
                                    <img src="{{ asset('storage/' . $item->foto) }}" id="preview_foto" class="img-thumbnail mt-2" style="max-width: 100%;">
                                @else
                                    <img id="preview_foto" class="img-thumbnail mt-2" style="display: none; max-width: 200px;">
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{-- MODAL LIHAT FOTO --}}
        <div class="modal fade" id="modalLihat{{ $item->id_foto_landing }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">FOTO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset('storage/' . $item->foto) }}" class="img-thumbnail">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- script preview gambar modal tambah --}}
    <script>
        function previewImage(input, previewId) {
            var file = input.files[0];
            var preview = document.getElementById(previewId);
    
            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = "none";
            }
        }
    
        document.getElementById("foto").addEventListener("change", function () {
            previewImage(this, "preview_foto");
        });
    </script>
@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection