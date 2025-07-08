@extends('layouts.master')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">FOTO</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Antrian Foto</h6>
            @php
                $jumlahAntrian = \App\Models\Foto::count();
                $cekAntrian = \App\Models\Foto::where('status_foto','Editing')->orderBy('antrian','asc')->first();
                if ($cekAntrian) {
                    $antrianSekarang = $cekAntrian->antrian;
                } else {
                    $antrianSekarang = 0;
                }
            @endphp
            <span class="badge badge-dark">Antrian Sekarang : {{ $antrianSekarang . '/' . $jumlahAntrian }}</span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">NO</th>
                            <th class="text-center">TANGGAL</th>
                            <th class="text-center">ANTRIAN</th>
                            {{-- <th class="text-center">ANTRIAN</th> --}}
                            <th class="text-center">CLIENT</th>
                            <th class="text-center">KAMPUS</th>
                            <th class="text-center">STATUS PEMBAYARAN</th>

                            <th class="text-center">STATUS FOTO</th>
                            {{-- <th class="text-center">ANTRIAN</th> --}}
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fotos as $item)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->pesanan->booking->tanggal }}</td>
                                <td class="text-center">{{ $item->antrian ?? '-' }}</td>
                                {{-- <td class="text-center">{{ $item->antrian }}</td> --}}
                                <td class="text-center">{{ $item->pesanan->booking->nama }}</td>
                                <td class="text-center">{{ $item->pesanan->booking->universitas ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($item->pesanan->booking->pesanan->status_pembayaran == "Lunas")
                                        <span class="badge badge-success">Lunas</span>
                                    @elseif ($item->pesanan->booking->pesanan->status_pembayaran == "Belum Lunas")
                                        <span class="badge badge-danger">Belum Lunas</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'Waiting for Photoshoot' => 'primary',
                                            'Uploading File' => 'info',
                                            'Sending File' => 'warning',
                                            'List File Edit' => 'info',
                                            'Editing' => 'primary',
                                            'Complete' => 'success'
                                        ];
                                        $status = $item->status_foto ?? '-'; // Jika null, set default "-"
                                        $badgeClass = $statusColors[$status] ?? 'dark'; // Gunakan 'dark' jika status tidak dikenali
                                    @endphp
                                    @if ($status !== '-')
                                        <span class="badge badge-{{ $badgeClass }}">{{ $status }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- <td>{{ $item->antrian ?? '-' }}</td> --}}
                                <td>
                                    <div class="d-flex justify-content-center">
                                        {{-- <a href="#" class="btn btn-secondary btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalLink{{ $item->id_foto }}" title="Link">
                                            <i class="fas fa-link"></i>
                                        </a> --}}
                                        <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_foto }}" title="Update">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </a>
                                        <form action="{{ route('admin.delete.foto',$item->id_foto) }}" method="POST" class="delete-form">
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


    @foreach ($fotos as $item)
        {{-- EDIT --}}
        <form id="fotoForm{{ $item->id_foto }}" action="{{ route('admin.update.foto',$item->id_foto) }}" method="post">
            @csrf
            @method('put')
            <div class="modal fade" id="modalEdit{{ $item->id_foto }}" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Foto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <input type="hidden" id="nama{{ $item->id_foto }}" value="{{ $item->pesanan?->booking?->nama }}">
                        <input type="hidden" id="no_wa{{ $item->id_foto }}" value="{{ $item->pesanan?->booking?->no_wa }}">
                    
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="status_foto{{ $item->id_foto }}" class="col-form-label">Status Foto</label>
                                <select id="status_foto{{ $item->id_foto }}" name="status_foto" class="form-control">
                                    <option value="">-- Pilih Status Foto --</option>
                                    <option value="Waiting for Photoshoot" {{ old('status_foto', $item->status_foto) == 'Waiting for Photoshoot' ? 'selected' : '' }}>Waiting for Photoshoot</option>
                                    <option value="Uploading File" {{ old('status_foto', $item->status_foto) == 'Uploading File' ? 'selected' : '' }}>Uploading File</option>
                                    <option value="Sending File" {{ old('status_foto', $item->status_foto) == 'Sending File' ? 'selected' : '' }}>Sending File</option>
                                    <option value="List File Edit" {{ old('status_foto', $item->status_foto) == 'List File Edit' ? 'selected' : '' }}>List File Edit</option>
                                    <option value="Editing" {{ old('status_foto', $item->status_foto) == 'Editing' ? 'selected' : '' }}>Editing</option>
                                    <option value="Complete" {{ old('status_foto', $item->status_foto) == 'Complete' ? 'selected' : '' }}>Complete</option>
                                </select>
                                @error('status_foto')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <div class="form-group">
                                <label for="link{{ $item->id_foto }}" class="col-form-label">Link Foto</label>
                                <textarea name="link" id="link{{ $item->id_foto }}" class="form-control @error('link') is-invalid @enderror">{{ old('link',$item->link) }}</textarea>
                                @error('link')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <div class="form-group">
                                <label for="list_foto">List Foto Edit</label>
                                @php
                                    $fotoEdit = json_decode($item->foto_edit, true); // decode sebagai array
                                    if (is_array($fotoEdit)) {
                                        sort($fotoEdit, SORT_NUMERIC); // urutkan sebagai angka
                                    }
                                @endphp
                            
                                @if (is_array($fotoEdit) && count($fotoEdit) > 0)
                                    <ul class="list-group">
                                        @foreach ($fotoEdit as $list)
                                            <li class="list-group-item">{{ $list }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">Tidak ada foto yang diedit.</p>
                                @endif
                            </div>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary submitFormBtn" data-id="{{ $item->id_foto }}">Simpan</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>

        <script>
    document.querySelectorAll('.submitFormBtn').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;
        const nama = document.getElementById(`nama${id}`).value;
        let no_wa = document.getElementById(`no_wa${id}`).value.trim();
        const link = document.getElementById(`link${id}`).value;
        const statusFoto = document.getElementById(`status_foto${id}`).value;
        let message = '';

        // Hapus karakter non-digit
        no_wa = no_wa.replace(/\D/g, '');

        // Convert jika diawali dengan '08'
        if (no_wa.startsWith('08')) {
            no_wa = '62' + no_wa.slice(1);
        }

        if (statusFoto === "Sending File") {
    message = `Halo ka ${nama}, Berikut ini untuk link foto originalnya yah

${link}

Nanti dipilih (Jumlah Photo) foto untuk kami edit,

misal di gdrivenya ada IMG_5678 langsung list aja di web ya kak (wajib berurutan nomer) :
1. IMG_5678
2. IMG_1234
dst

List photo edit langsung di Input di Web tersimpancerita.id, Input secara satu per satu di Menu "Pilih Photo Edit", sebagai contoh Input Listnya :

Ketikan Nomer Photo : IMG_5678, lalu Enter (Bukan Submit ya ka) dan seterusnya sampai Selesai

Massa simpan foto di Drive 14 hari terhitung dari hari ini ya ka, jadi mohon untuk langsung di backup/download menggunakan Laptop atau PC

Terimakasih sebelumnya kak...`.trim();
} else if (statusFoto === "Complete") {
            message = `Halo ka ${nama}, 

Kami berterimakasih atas kepercayaan yang telah Ka ${nama} beri, untuk menjadi saksi dari akhir lembaran Cerita semasa Kuliah. Semoga sukses dan lancar untuk Chapter menarik lainnya.

Berikut ini rangkaian kisah yang Tersimpan dalam lukisan cahaya :

${link}

Sekali lagi terimakasih telah berlayar bersama kami — Doa serta Harapan senantiasa bahagia kekal dan abadi.

dan kami ingatkan kembali untuk backup atau download foto yang telah kami kirimkan yah kak, mengingat massa simpannya hanya sementara :)`.trim();
        }

        if (message !== '' && no_wa !== '') {
            const encodedMessage = encodeURIComponent(message);
            const whatsappUrl = `https://wa.me/${no_wa}?text=${encodedMessage}`;
            window.open(whatsappUrl, '_blank');
        }

        // Submit form
        document.getElementById(`fotoForm${id}`).submit();
    });
});
</script>
    @endforeach

@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection