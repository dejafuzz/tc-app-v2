@extends('layouts.master')
@section('content')

    <style>
        /* Mengatur tampilan select agar mirip dengan textarea */
        .select2-container .select2-selection--multiple {
            height: 300px; /* Sesuaikan tinggi dengan yang diinginkan */
            resize: none; /* Menonaktifkan kemampuan untuk meresize */
            padding: 8px; /* Menambahkan padding seperti textarea */
            border-radius: 4px; /* Menambahkan border-radius untuk melengkungkan sudut */
            border: 1px solid #ccc; /* Menyesuaikan border untuk tampilan textarea */
        }

        .select2-container .select2-selection--multiple .select2-selection__rendered {
            padding: 6px 8px; /* Menyesuaikan padding bagian dalam untuk teks */
        }

        .select2-container .select2-search--multi .select2-search__field {
            height: 35px; /* Menyesuaikan tinggi input pencarian */
            padding: 8px; /* Menambah padding agar konsisten dengan textarea */
        }

        /* Menambahkan tampilan scroll jika pilihan banyak */
        .select2-container .select2-results__options {
            max-height: 200px; /* Membatasi tinggi dropdown agar tetap terlihat */
            overflow-y: auto; /* Mengaktifkan scroll vertikal */
        }
    </style>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">KELOLA PAKET</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Paket</h6>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-solid fa-folder-plus fa-sm text-white-50"></i> Tambah Paket
            </button>
        </div>

        {{-- TAMBAH --}}
        <div class="modal fade" id="modalTambah" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Paket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.store.paket') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kp_id" class="col-form-label">Kategori Paket</label>
                                <select id="inputState" name="kp_id" class="form-control @error('kp_id') is-invalid @enderror">
                                    <option>-- Pilih Kategori Paket --</option>
                                    @foreach ($kp as $item)
                                        <option value="{{ $item->id_kp }}" {{ old('kp_id') == $item->id_kp ? 'selected' : '' }}>{{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kp_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nama_paket" class="col-form-label">Nama Paket</label>
                                <input 
                                    type="text" 
                                    name="nama_paket" 
                                    class="form-control @error('nama_paket') is-invalid @enderror" 
                                    id="nama_paket" 
                                    value="{{ old('nama_paket') }}" 
                                    placeholder="Masukkan Nama Paket">
                                @error('nama_paket')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kp_id" class="col-form-label">Fitur</label>
                                <select class="form-control js-example-tokenizer" style="width: 100%; height: 300px;" multiple="multiple" name="fitur[]">
                                </select>
                            </div>
                            
                            {{-- <div class="form-group">
                                <label for="fitur" class="col-form-label">Fitur Paket</label>
                                <textarea class="form-control" name="fitur" id="fitur" cols="30" rows="10"></textarea>
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
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">NO</th>
                            <th class="text-center">ID</th>
                            <th class="text-center">NAMA PAKET</th>
                            <th class="text-center">KATEGORI PAKET</th>
                            {{-- <th class="text-center">TANGGAL</th> --}}
                            <th class="text-center">FITUR PAKET</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paket as $item)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->id_paket }}</td>
                                <td class="text-center">{{ $item->nama_paket }}</td>
                                <td class="text-center">{{ $item->kategori_paket->nama_kategori }}</td>
                                {{-- <td class="text-center">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td> --}}
                                <td class="text-left">
                                    @php
                                        $fiturs = json_decode($item->fitur);
                                        // dd($fiturs);
                                    @endphp
                                    @foreach ($fiturs as $fitur)
                                        <li>{{ $fitur }}</li>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_paket }}" title="Update">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </a>
                                        <form action="{{ route('admin.delete.paket', ['id' => $item->id_paket]) }}" method="POST" class="delete-form">
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
                                            text: "Data client yang terkait juga akan terhapus!",
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
                            {{-- @include('admin.paket.modal',['item' => $item]) --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($paket as $item)
        {{-- EDIT --}}
        <div class="modal fade" id="modalEdit{{ $item->id_paket }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Paket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.update.paket', ['id' => $item->id_paket]) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kp_id" class="col-form-label">Kategori Paket</label>
                                <select id="inputState" name="kp_id" class="form-control @error('kp_id') is-invalid @enderror">
                                    <option>-- Pilih Kategori Paket --</option>
                                    
                                    @foreach ($kp as $k)
                                        <option value="{{ $k->id_kp }}" {{ old('kp_id',$item->kp_id) == $k->id_kp ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kp_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nama_paket" class="col-form-label">Nama Paket</label>
                                <input 
                                    type="text" 
                                    name="nama_paket" 
                                    class="form-control @error('nama_paket') is-invalid @enderror" 
                                    id="nama_paket" 
                                    value="{{ old('nama_paket',$item->nama_paket) }}" 
                                    placeholder="Masukkan Nama Paket">
                                @error('nama_paket')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @php
                                $fitursUpdate = json_decode($item->fitur);
                            @endphp

                            <div class="form-group">
                                <label for="kp_id" class="col-form-label">Fitur</label>
                                <select class="form-control js-example-tokenizer" style="width: 100%; height: 300px;" multiple="multiple" name="fitur[]">
                                    @foreach ($fitursUpdate as $fitur)
                                        <option value="{{ $fitur }}" selected>{{ $fitur }}</option>
                                    @endforeach
                                </select>
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
    @endforeach

    {{-- <script>
        $(".js-example-tokenizer").select2({
            tags: true,
            allowClear: true,
            placeholder: "Fitur Paket",
            tokenSeparators: [',', ' '],
        })
    </script> --}}

    <script>
        // $(document).ready(function() {
            $(".js-example-tokenizer").select2({
                tags: true,                 // Mengizinkan input custom
                allowClear: true,           // Mengizinkan penghapusan semua pilihan
                placeholder: "Fitur Paket", // Placeholder untuk dropdown
                createTag: function(params) {
                    var term = $.trim(params.term); // Menghapus spasi ekstra
                    if (term === '') {
                        return null; // Jangan tambahkan tag jika input kosong
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true // Tandai bahwa ini adalah tag baru
                    };
                },
                tokenSeparators: [] // Menghapus pemisah token, memungkinkan input spasi
            });
        // });
    </script>

@include('validasi.notifikasi')
@include('validasi.notifikasi-error')


@endsection