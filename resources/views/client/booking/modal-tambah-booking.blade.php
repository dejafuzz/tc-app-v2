{{-- TAMBAH --}}
<form id="tambahBookingForm" action="{{ route('client.store.booking') }}" method="POST">
    @csrf
    <div class="modal fade" id="modalTambah" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="col-form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('nama',Auth::user()->name) }}" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" value="{{ old('email',Auth::user()->email) }}" name="email" class="form-control @error('email') is-invalid @enderror" id="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="no_wa" class="col-form-label">No. WA <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('no_wa') }}" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror" id="no_wa">
                                @error('no_wa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="event" class="col-form-label">Event <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('event') }}" name="event" class="form-control @error('event') is-invalid @enderror" id="event">
                                @error('event')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tanggal" class="col-form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" value="{{ old('tanggal') }}" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal">
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jam" class="col-form-label">Jam <span class="text-danger">*</span></label>
                                <input type="time" value="{{ old('jam') }}" name="jam" class="form-control @error('jam') is-invalid @enderror" id="jam">
                                @error('jam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kota" class="col-form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('kota') }}" name="kota" class="form-control @error('kota') is-invalid @enderror" id="kota">
                                @error('kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="universitas" class="col-form-label">Universitas <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('universitas') }}" name="universitas" class="form-control @error('universitas') is-invalid @enderror" id="universitas">
                                @error('universitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fakultas" class="col-form-label">Fakultas <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('fakultas') }}" name="fakultas" class="form-control @error('fakultas') is-invalid @enderror" id="fakultas">
                                @error('fakultas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lokasi_foto" class="col-form-label">Lokasi Foto <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('lokasi_foto') }}" name="lokasi_foto" class="form-control @error('lokasi_foto') is-invalid @enderror" id="lokasi_foto">
                                @error('lokasi_foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="ig_client" class="col-form-label">Instagram</label>
                                <input type="text" value="{{ old('ig_client') }}" name="ig_client" class="form-control @error('ig_client') is-invalid @enderror" id="ig_client">
                                @error('ig_client')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="post_foto" class="col-form-label">Post Foto</label>
                                <select id="post_foto" name="post_foto" class="form-control @error('post_foto') is-invalid @enderror">
                                    <option selected disabled value="">--Pilih--</option>
                                    <option value="Bersedia" {{ old('post_foto') == 'Bersedia' ? 'selected' : '' }}>Bersedia</option>
                                    <option value="Tidak Bersedia" {{ old('post_foto') == 'Tidak Bersedia' ? 'selected' : '' }}>Tidak Bersedia</option>
                                </select>
                                @error('post_foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jumlah_anggota" class="col-form-label">Jumlah Anggota <span class="text-danger">*</span></label>
                                <input type="number" value="{{ old('jumlah_anggota') }}" name="jumlah_anggota" class="form-control @error('jumlah_anggota') is-invalid @enderror" id="jumlah_anggota">
                                @error('jumlah_anggota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="harga_paket_id" class="col-form-label">Paket <span class="text-danger">*</span></label>
                                <select id="harga_paket_id" name="harga_paket_id" class="js-example-basic-single @error('harga_paket_id') is-invalid @enderror" style="width: 100%; height: 300px;">
                                    <option selected disabled value="">--Pilih Paket--</option>
                                    @foreach ($hargaPaket as $harga)
                                        <option value="{{ $harga->id_harga_paket }}" 
                                            {{ old('harga_paket_id') == $harga->id_harga_paket ? 'selected' : '' }}>
                                            
                                            {{ $harga->paket->kategori_paket->nama_kategori . ' ' . $harga->paket->nama_paket . ' | ' }}
                                            
                                            @php
                                                $namaWilayah = \App\Models\Wilayah::where('kode', $harga->golongan)->pluck('nama_wilayah')->toArray();
                                            @endphp
                            
                                            {{ implode(', ', $namaWilayah) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('harga_paket_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="kp_id" class="col-form-label">Pilih Paket Tambahan</label>
                        <select class="form-control js-paket-tambahan" 
                            style="width: 100%; height: 300px;" 
                            multiple="multiple" name="paket_tambahan[]">
                            @foreach ($paketTambahan as $pt)
                                <option value="{{ $pt->id_paket_tambahan }}" 
                                    @if (isset($item) && $item->paketTambahan->contains('id_paket_tambahan', $pt->id_paket_tambahan)) selected @endif>
                                    {{ $pt->jenis_tambahan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="req_khusus" class="col-form-label">Catatan</label>
                        <textarea name="req_khusus" class="form-control @error('req_khusus') is-invalid @enderror" id="req_khusus" rows="3">{{ old('req_khusus') }}</textarea>
                        @error('req_khusus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="submitForm" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</form>


{{-- <script>
    document.getElementById('submitForm').addEventListener('click', function () {
// Ambil data dari form
const nama = document.getElementById('nama').value;
const email = document.getElementById('email').value;
const noWa = document.getElementById('no_wa').value;
const igClient = document.getElementById('ig_client').value || '-';
const tanggalRaw = document.getElementById('tanggal').value;
const universitas = document.getElementById('universitas').value;
const kota = document.getElementById('kota').value;

// Validasi form
// if (!nama || !email || !noWa || !universitas || !kota) {
//     alert('Harap lengkapi semua field yang bertanda *');
//     return;
// }

// Ubah format tanggal dari yyyy-mm-dd ke dd/mm/yyyy
let tanggalFormatted = '-';
if (tanggalRaw) {
    const dateObj = new Date(tanggalRaw);
    tanggalFormatted = dateObj.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

// Format pesan WhatsApp
// const message = `Halo kak, saya dengan biodata berikut:

// *Nama:* ${nama}
// *Email:* ${email}
// *No. WA:* ${noWa}
// *Instagram:* ${igClient}
// *Tanggal Foto:* ${tanggalFormatted}
// *Universitas:* ${universitas}
// *Area:* ${kota}

// Saya ingin meminta price list.`.trim();
const message = `Hi ka, saya sudah mengisi Form Booking nya, selanjutnya bagaimana yah?`.trim();

// Encode pesan untuk URL
const encodedMessage = encodeURIComponent(message);

// Nomor tujuan WhatsApp
const whatsappNumber = '6285156272866';
// const whatsappNumber = '6285878653934';

// Buat URL WhatsApp
const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

// Redirect ke WhatsApp
window.open(whatsappUrl, '_blank');

// Submit form ke server
document.getElementById('tambahBookingForm').submit();
});

</script> --}}