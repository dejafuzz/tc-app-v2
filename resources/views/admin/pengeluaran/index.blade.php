@extends('layouts.master')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">KELOLA PENGELUARAN</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Pengeluaran</h6>
            <!-- Actions -->
            <div class="d-flex align-items-center flex-wrap">
                <!-- Tanggal Keberangkatan Input -->
                <form id="formFilterPengeluaran" action="{{ route('admin.export.pengeluaran') }}" method="GET" class="d-flex align-items-center mr-3">
                    <div class="form-group d-flex mb-0 align-items-center">
                        <input type="month" name="bulan" value="{{ request()->get('bulan') }}" id="filterTanggal"
                            class="form-control form-control-sm mr-2" placeholder="Pilih bulan">
                        <button type="submit" class="btn btn-sm btn-primary shadow-sm d-flex align-items-center">
                            <i class="fas fa-file-export fa-sm text-white-50 mr-1"></i> Export
                        </button>
                    </div>
                </form>
            </div>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-solid fa-chart-bar fa-sm text-white-50"></i> Tambah Pengeluaran
            </button>
        </div>

        {{-- TAMBAH --}}
        <div class="modal fade" id="modalTambah" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Pengeluaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.store.pengeluaran') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="tanggal_transaksi" class="col-form-label">Tanggal Transaksi</label>
                                <input 
                                    type="date" 
                                    name="tanggal_transaksi" 
                                    id="tanggal_transaksi" 
                                    class="form-control @error('tanggal_transaksi') is-invalid @enderror" 
                                    value="{{ old('tanggal_transaksi') }}" 
                                    placeholder="Masukkan Nama">
                                @error('tanggal_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jenis_pengeluaran_id" class="col-form-label">Jenis Pengeluaran</label>
                                <select 
                                    id="inputState" 
                                    name="jenis_pengeluaran_id" 
                                    class="form-control @error('jenis_pengeluaran_id') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis --</option>
                                    @foreach ($jenisPengeluaran as $jp)
                                        <option value="{{ $jp->id_jenis_pengeluaran }}">{{ $jp->jenis_pengeluaran }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_pengeluaran_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deskripsi" class="col-form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" rows="3" placeholder="Masukkan Deskripsi">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="nominal" class="col-form-label">Nominal</label>
                                <input 
                                    type="text" 
                                    name="nominal" 
                                    id="nominal" 
                                    oninput="formatNumber(this)"
                                    class="form-control @error('nominal') is-invalid @enderror" 
                                    value="{{ old('nominal') }}" 
                                    placeholder="Masukkan Nominal">
                                @error('nominal')
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
                <table class="table table-bordered" id="pengeluaran" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">NO</th>
                            <th class="text-center">TANGGAL TRANSAKSI</th>
                            <th class="text-center">JENIS PENGELUARAN</th>
                            <th class="text-center">DESKRIPSI</th>
                            <th class="text-center">NOMINAL</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="pengeluaran-table-body">
                        @foreach ($pengeluaran as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $item->tanggal_transaksi }}</td>
                            <td>{{ $item->jenis_pengeluaran->jenis_pengeluaran }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>{{ 'Rp. ' . number_format($item->nominal ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_pengeluaran }}" title="Update">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </a>
                                    <form action="{{ route('admin.delete.pengeluaran', ['id' => $item->id_pengeluaran]) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-circle btn-sm delete-btn mr-2" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="4">Total Omset Kotor</td>
                            <td colspan="2" class="text-right" id="total_omset_kotor">Rp. {{ number_format($totalOmsetKotor ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4">Total Pengeluaran</td>
                            <td colspan="2" class="text-right" id="total_pengeluaran">Rp. {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><strong>Omset Bersih</strong></td>
                            <td colspan="2" class="text-right"><strong id="total_omset_bersih">Rp. {{ number_format($totalOmsetBersih ?? 0, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Tampilkan Modal di luar <tr> --}}
        @foreach ($pengeluaran as $item)
        <div class="modal fade" id="modalEdit{{ $item->id_pengeluaran }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pengeluaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.update.pengeluaran', ['id' => $item->id_pengeluaran]) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tanggal_transaksi">Tanggal Transaksi</label>
                                <input 
                                    type="date" 
                                    name="tanggal_transaksi" 
                                    class="form-control @error('tanggal_transaksi') is-invalid @enderror" 
                                    value="{{ old('tanggal_transaksi', $item->tanggal_transaksi) }}">
                                @error('tanggal_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jenis_pengeluaran_id">Jenis Pengeluaran</label>
                                <select name="jenis_pengeluaran_id" class="form-control @error('jenis_pengeluaran_id') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis --</option>
                                    @foreach ($jenisPengeluaran as $jp)
                                        <option value="{{ $jp->id_jenis_pengeluaran }}" {{ old('jenis_pengeluaran_id', $item->jenis_pengeluaran_id) == $jp->id_jenis_pengeluaran ? 'selected' : '' }}>
                                            {{ $jp->jenis_pengeluaran }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_pengeluaran_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="nominal">Nominal</label>
                                <input 
                                    type="text" 
                                    name="nominal" 
                                    oninput="formatNumber(this)"
                                    class="form-control @error('nominal') is-invalid @enderror" 
                                    value="{{ old('nominal', number_format($item->nominal ?? 0, 0, ',', '.')) }}">
                                @error('nominal')
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
        @endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- SweetAlert Delete --}}
    <script>
        // Delegasi event untuk tombol delete dalam #pengeluaran-table-body
        document.getElementById('pengeluaran-table-body').addEventListener('click', function (e) {
            if (e.target.closest('.delete-btn')) {
                e.preventDefault();
    
                const button = e.target.closest('.delete-btn');
                const form = button.closest('form');
    
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
            }
        });
    </script>

    <script>
        function formatNumber(input) {
            // Menghapus semua karakter selain angka
            let value = input.value.replace(/\D/g, '');
        
            // Menambahkan titik setiap 3 digit
            let formattedValue = new Intl.NumberFormat('id-ID').format(value);
        
            // Mengatur kembali nilai input
            input.value = formattedValue;
        }
    </script>

{{-- <script>
    document.getElementById('filterTanggal').addEventListener('change', function () {
        const bulan = this.value;

        // Ubah URL di address bar tanpa reload
        const newUrl = `${window.location.pathname}?bulan=${bulan}`;
        window.history.pushState({ path: newUrl }, '', newUrl);

        fetch(`{{ route('admin.pengeluaran') }}?bulan=${bulan}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('pengeluaran-table-body').innerHTML = data.table;
            document.getElementById('totalPengeluaran').innerText = data.total_pengeluaran;
            document.getElementById('totalOmsetKotor').innerText = data.total_omset_kotor;
            document.getElementById('totalOmsetBersih').innerText = data.total_omset_bersih;
        });
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterTanggal = document.getElementById('filterTanggal');

        filterTanggal.addEventListener('change', function () {
            const bulan = this.value;

            fetch(`/admin/pengeluaran/filter?bulan=${bulan}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('pengeluaran-table-body');
                tbody.innerHTML = '';

                let html = '';
                data.pengeluaran.forEach((item, index) => {
                    html += `
                        <tr class="text-center">
                            <td>${index + 1}</td>
                            <td>${item.tanggal_transaksi}</td>
                            <td>${item.jenis_pengeluaran}</td>
                            <td>${item.deskripsi}</td>
                            <td>Rp. ${parseInt(item.nominal).toLocaleString('id-ID')}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit${item.id_pengeluaran}" title="Update">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </a>
                                    <form action="/admin/delete/pengeluaran/${item.id_pengeluaran}" method="POST" class="delete-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="delete">
                                        <button type="submit" class="btn btn-danger btn-circle btn-sm delete-btn mr-2" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                tbody.innerHTML = html;

                // Update total
                document.getElementById('total_omset_bersih').textContent = `Rp. ${parseInt(data.totalOmsetBersih).toLocaleString('id-ID')}`;
                document.getElementById('total_pengeluaran').textContent = `Rp. ${parseInt(data.totalPengeluaran).toLocaleString('id-ID')}`;
                document.getElementById('total_omset_kotor').textContent = `Rp. ${parseInt(data.totalOmsetKotor).toLocaleString('id-ID')}`;
            });
        });
    });
</script>

@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection