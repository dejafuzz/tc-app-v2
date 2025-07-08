{{-- @php
    $totalPengeluaran = session('totalPengeluaran', 0); // Mengambil nilai session jika ada, atau 0 jika belum ada
@endphp --}}

@foreach ($pengeluaran as $item)
    <tr class="text-center">
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->tanggal_transaksi }}</td>
        <td>{{ $item->jenis_pengeluaran->jenis_pengeluaran }}</td>
        <td>{{ $item->deskripsi }}</td>
        {{-- @php
            $totalPengeluaran += $item->nominal; // Menambahkan nominal
            session(['totalPengeluaran' => $totalPengeluaran]); // Simpan totalPengeluaran di session
        @endphp --}}
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

