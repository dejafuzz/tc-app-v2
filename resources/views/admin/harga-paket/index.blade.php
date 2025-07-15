@extends('layouts.master')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">KELOLA HARGA PAKET</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Harga Paket</h6>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-solid fa-folder-plus fa-sm text-white-50"></i> Tambah Harga
            </button>
        </div>

        {{-- TAMBAH --}}
        <div class="modal fade" id="modalTambah" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Harga</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.store.harga-paket') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="paket_id" class="col-form-label">Nama Paket</label>
                                <select id="inputState" name="paket_id" class="form-control @error('paket_id') is-invalid @enderror">
                                    <option selected disabled value="">-- Pilih Paket --</option>
                                    @foreach ($paket as $item)
                                        <option value="{{ $item->id_paket }}" {{ old('paket_id') == $item->id_paket ? 'selected' : '' }}>{{ $item->kategori_paket->nama_kategori . ' ' . $item->nama_paket }}</option>
                                    @endforeach
                                </select>
                                @error('paket_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="golongan" class="col-form-label">Golongan Wilayah</label>
                                <select id="inputState" name="golongan" class="form-control @error('golongan') is-invalid @enderror">
                                    <option selected disabled value="">-- Pilih --</option>
                                    <option value="W1" {{ old('golongan') == 'W1' ? 'selected' : '' }}>Wilayah 1</option>
                                    <option value="W2" {{ old('golongan') == 'W2' ? 'selected' : '' }}>Wilayah 2</option>
                                    <option value="W3" {{ old('golongan') == 'W3' ? 'selected' : '' }}>Wilayah 3</option>
                                    <option value="W4" {{ old('golongan') == 'W4' ? 'selected' : '' }}>Wilayah 4</option>
                                </select>
                                @error('golongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="harga" class="col-form-label">Harga Paket</label>
                                <input type="number" value="{{ old('harga') }}" min="1" name="harga" class="form-control @error('harga') is-invalid @enderror" id="harga">
                                @error('harga')
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
                <table class="table table-bordered table-striped table-hover" id="harga_paket" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">NO</th>
                            {{-- <th class="text-center">ID</th> --}}
                            {{-- <th class="text-center">CREATED_AT</th> --}}
                            <th class="text-center">NAMA PAKET</th>
                            <th class="text-center">GOLONGAN WILAYAH</th>
                            <th class="text-center">HARGA PAKET</th>
                            {{-- <th class="text-center">paket id</th> --}}
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hargaPaket as $item)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                {{-- <td class="text-center">{{ $item->id_harga_paket }}</td> --}}
                                {{-- <td class="text-center">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td> --}}
                                <td class="text-center">{{ $item->paket->kategori_paket->nama_kategori . ' ' . $item->paket->nama_paket }}</td>
                                <td class="text-center">{{ $item->golongan }}</td>
                                <td class="text-center">{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
                                {{-- <td class="text-center">{{ $item->paket_id }}</td> --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-success btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalDetail{{ $item->id_harga_paket }}"  title="Detail">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_harga_paket }}" title="Update">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </a>
                                        <form action="{{ route('admin.delete.harga-paket', $item->id_harga_paket) }}" method="POST" class="delete-form">
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
                            {{-- @include('admin.harga-paket.modal',['item' => $item]) --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($hargaPaket as $item)
        {{-- EDIT --}}
        <div class="modal fade" id="modalEdit{{ $item->id_harga_paket }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Harga Paket {{ $item->paket->kategori_paket->nama_kategori . ' ' . $item->paket->nama_paket . ' ' . $item->golongan }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.update.harga-paket', $item->id_harga_paket) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            {{-- <div class="form-group">
                                <label for="paket_id" class="col-form-label">Nama Paket</label>
                                <select id="inputState" name="paket_id" class="form-control @error('paket_id') is-invalid @enderror">
                                    <option selected disabled value="">-- Pilih Paket --</option>
                                    @foreach ($paket as $p)
                                        <option value="{{ $p->id_paket }}" {{ old('paket_id',$item->paket_id) == $p->id_paket ? 'selected' : '' }}>{{ $p->kategori_paket->nama_kategori . ' ' . $p->nama_paket }}</option>
                                    @endforeach
                                </select>
                                @error('paket_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="golongan" class="col-form-label">Golongan Wilayah</label>
                                <select id="inputState" name="golongan" class="form-control @error('golongan') is-invalid @enderror">
                                    <option selected disabled value="">-- Pilih --</option>
                                    <option value="W1" {{ old('golongan',$item->golongan) == 'W1' ? 'selected' : '' }}>Wilayah 1</option>
                                    <option value="W2" {{ old('golongan',$item->golongan) == 'W2' ? 'selected' : '' }}>Wilayah 2</option>
                                </select>
                                @error('golongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <label for="harga" class="col-form-label">Harga Paket</label>
                                <input type="number" value="{{ old('harga',$item->harga) }}" min="1" name="harga" class="form-control @error('harga') is-invalid @enderror" id="harga">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="golongan" class="col-form-label">Golongan Wilayah</label>
                                <select id="inputState" name="golongan" class="form-control @error('golongan') is-invalid @enderror">
                                    <option selected disabled value="">-- Pilih --</option>
                                    <option value="W1" {{ old('golongan', $item->golongan) == 'W1' ? 'selected' : '' }}>Wilayah 1</option>
                                    <option value="W2" {{ old('golongan', $item->golongan) == 'W2' ? 'selected' : '' }}>Wilayah 2</option>
                                    <option value="W3" {{ old('golongan', $item->golongan) == 'W3' ? 'selected' : '' }}>Wilayah 3</option>
                                    <option value="W4" {{ old('golongan', $item->golongan) == 'W4' ? 'selected' : '' }}>Wilayah 4</option>
                                </select>
                                @error('golongan')
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
        <div class="modal fade" id="modalDetail{{ $item->id_harga_paket }}" tabindex="-1" aria-labelledby="DetailLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetailLabel">Detail Harga</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Nama Paket: {{ $item->paket->kategori_paket->nama_kategori . ' ' . $item->paket->nama_paket }}</label>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Fitur: 
                                @php
                                    $fiturs = json_decode($item->paket->fitur);
                                @endphp
                                @foreach ($fiturs as $fitur)
                                    <li>{{ $fitur }}</li>
                                @endforeach
                            </label>
                        </div>
                        @php
                            $cekWil = \App\Models\Wilayah::where('kode',$item->golongan)->get();
                            // dd($cekWil);
                        @endphp
                        <div class="mb-3">
                            <label for="userLevel" class="form-label">Harga: 
                                <li>{{ 'Rp. ' . number_format($item->harga, 0, ',', '.') }} (
                                    @foreach ($cekWil as $wil)
                                        {{ $wil->nama_wilayah . ',' }}
                                    @endforeach
                                    )
                                </li>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection