@extends('layouts.master')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">KELOLA PAKET LANDING</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-wrap align-items-center">
        <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Paket Landing</h6>
        <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
            <i class="fas fa-solid fa-folder-plus fa-sm text-white-50"></i> Tambah Paket
        </button>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Paket</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('admin.store.paket.landing') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Paket</label>
                            <select name="paket_id" class="form-control @error('paket_id') is-invalid @enderror">
                                <option value="" selected>-- Pilih Paket --</option>
                                @foreach($paket as $p)
                                    <option value="{{ $p->id_paket }}" {{ old('paket_id') == $p->id_paket ? 'selected' : '' }}>{{ $p->kategori_paket->nama_kategori }} - {{ $p->nama_paket }}</option>
                                @endforeach
                            </select>
                            @error('paket_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Posted" {{ old('status') == 'Posted' ? 'selected' : '' }}>Posted</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

    {{-- TABEL --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">PAKET</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paketLanding as $item)
                    <tr class="text-center">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->paket->kategori_paket->nama_kategori }} - {{ $item->paket->nama_paket }}</td>
                        <td>
                            @if ($item->status == 'Pending')
                                <span class="badge badge-info">Pending</span>
                            @else
                                <span class="badge badge-success">Posted</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_pl }}"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.delete.paket.landing', ['id' => $item->id_pl]) }}" method="POST" class="delete-form">
                                    @csrf @method('delete')
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm delete-btn"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach ($paketLanding as $item)
    {{-- MODAL EDIT --}}
    <div class="modal fade" id="modalEdit{{ $item->id_pl }}">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Paket</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('admin.update.paket.landing', ['id' => $item->id_pl]) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Paket</label>
                            <select name="paket_id" class="form-control">
                                @foreach($paket as $p)
                                    <option value="{{ $p->id_paket }}" {{ $item->paket_id == $p->id_paket ? 'selected' : '' }}>{{ $p->kategori_paket->nama_kategori }} - {{ $p->nama_paket }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="Pending" {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Posted" {{ $item->status == 'Posted' ? 'selected' : '' }}>Posted</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- SweetAlert Delete --}}
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');

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
                    form.submit();
                }
            });
        });
    });
</script>

@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection
