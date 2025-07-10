<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Faktur Tersimpan Cerita</title>
    <style>
        @page {
        margin: 10mm; /* Narrow margin, bisa kamu ubah sesuai kebutuhan */
    }
        body {
        font-family: Arial, sans-serif;
        margin: 40px;
        color: #000;
        margin: 0;
        padding: 0;
        }
        .header,
        .footer,
        .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        }
        .header .logo {
        width: 120px;
        }
        .header .company-info {
        text-align: right;
        }
        .invoice-to,
        .invoice-details {
        background-color: #f0f2f2;
        padding: 10px;
        }
        .invoice-header {
        margin-top: 20px;
        }
        table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        }
        th,
        td {
        padding: 15px;
        text-align: left;
        vertical-align: top;
        }
        th {
        background-color: #f0f2f2;
        }
        .total {
        margin-top: 20px;
        padding: 10px;
        background-color: #f0f2f2;
        text-align: right;
        font-size: 16px;
        }
        .payment-info {
        margin-top: 20px;
        font-size: 16px;
        }
        .dp-info {
        margin-top: 40px;
        font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 120px; vertical-align: top;">
                    <img src="img/tc-hitam.png" alt="Logo" style="width: 100%;">
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <strong>Tersimpan Cerita</strong><br>
                    Jl.Kober, Gang Dahlia No.22<br>
                    Banyumas Jawa Tengah 54132<br>
                    ID<br>
                    +62851-5627-2866<br>
                    tersimpancerita@gmail.com
                </td>
            </tr>
        </table>
    </div>

    <div class="invoice-header">
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="width: 50%; vertical-align: top; background-color: #f0f2f2; padding: 10px; text-align: left;">
                    <strong>DITAGIH KEPADA</strong><br>
                    {{ $pesanan->booking->nama . ' ' . $pesanan->booking->tanggal . ', ' . $pesanan->booking->universitas }} <br>
                    @php
                        $waNumber = $pesanan->booking->no_wa;
                        // Cek apakah nomor WA dimulai dengan '0'
                        if (substr($waNumber, 0, 1) === '0') {
                            $waNumber = '+62' . substr($waNumber, 1); // Ganti '0' dengan '62'
                        }
                    @endphp
                    {{ $waNumber }}
                </td>
                <td style="width: 50%; vertical-align: top; background-color: #f0f2f2; padding: 10px; text-align: right;">
                    <strong>Tersimpan Cerita #</strong> {{ $pesanan->faktur }}<br>
                    <strong>Tanggal</strong> {{ \Carbon\Carbon::parse($pesanan->booking?->tanggal_dp)->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Barang</th>
                <th>Kuantitas</th>
                <th>Harga</th>
                <th></th>
                <th></th>
                <th>Jumlah</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                $kuantitas = 1;
                $jumlahHargaTambahan = 0;
                $total = $pesanan->booking->harga * $kuantitas;
            @endphp
            <tr>
                <td>
                    <strong>{{ $pesanan->booking->harga_paket->paket->kategori_paket->nama_kategori . ' ' . $pesanan->booking->harga_paket->paket->nama_paket . ' ' . $pesanan->booking->kota }}</strong><br>
                    @php
                        $namaWilayah = \App\Models\Wilayah::where('kode', $pesanan->booking->harga_paket->golongan)->pluck('nama_wilayah')->toArray();
                        // dd($pesanan->harga_paket_tambahan);
                    @endphp

                    {{ implode(', ', $namaWilayah) }}<br>
                    
                    @php
                        $fiturs = json_decode($pesanan->booking->harga_paket->paket->fitur);
                    @endphp
                    @foreach ($fiturs as $item)
                        - {{ $item }}<br>
                    @endforeach
                </td>
                <td style="text-align: center">1</td>
                <td colspan="3">{{ 'Rp ' . number_format($pesanan->booking->harga, 0, ',', '.') ?? '-' }}</td>
                <td colspan="2">{{ 'Rp ' . number_format($total, 0, ',', '.') ?? '-' }}</td>
            </tr>
            
            <tr>
                <td colspan="4" style="font-weight: bold; text-align: center;">PAKET TAMBAHAN</td>
            </tr>

            <tr>
                <td>
                    @php
                        $qty = 0;
                    @endphp
                    @foreach ($pesanan->booking->bookingPaketTambahan as $item)
                        @php
                            $qty += 1;
                        @endphp
                        - {{ $item->paketTambahan->jenis_tambahan }} <br>
                    @endforeach
                </td>
                {{-- <td>1</td> --}}
                {{-- <td>{{ 'Rp ' . number_format($item->paketTambahan->harga_tambahan, 0, ',', '.') ?? '-' }}</td>
                <td>{{ 'Rp ' . number_format($item->paketTambahan->harga_tambahan, 0, ',', '.') ?? '-' }}</td> --}}
            </tr>

            <tr>
                <td><strong>Total Harga Paket Tambahan:</strong></td>
                <td></td>
                {{-- <td></td> --}}
                <td colspan="5" style="text-align: right;">{{ 'Rp ' . number_format($pesanan->harga_paket_tambahan, 0, ',', '.') ?? '-' }}</td>
            </tr>
            @php
                $jumlahHargaTambahan += $pesanan->harga_paket_tambahan; 
            @endphp
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="vertical-align: top; width: 60%;">
                <div class="payment-info">
                <strong>Instruksi pembayaran</strong>
                </div>
                <div style="font-size: 16px; color: rgb(51, 51, 51);">Bank BCA Digital : 0900-12011708 (A.N Ahmad Reza Rizky Setio Aji)</div>
            </td>

            @php
                $jumlahSeluruh = $total + $jumlahHargaTambahan;
                // dd($total);
            @endphp

            <td style="vertical-align: top; text-align: right;">
                <div class="total" style="text-align: right; background-color: transparent; padding: 0;">
                    <table style="width: 100%; border-spacing: 0; margin-top: 0;">
                        <tr>
                            <td style="text-align: right; padding-top: 6px; padding-bottom: 2px;">Subtotal:</td>
                            <td style="text-align: right; padding-top: 6px; padding-bottom: 2px;">{{ 'Rp. ' . number_format($jumlahSeluruh, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; padding-top: 6px; padding-bottom: 2px;">Discount:</td>
                            <td style="text-align: right; padding-top: 6px; padding-bottom: 2px;">{{ 'Rp. ' . number_format($pesanan->discount, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            @if ($pesanan->booking->pelunasan)
                                <td style="text-align: right; padding-top: 6px; padding-bottom: 2px;">Pelunasan:</td>
                                <td style="text-align: right; padding-top: 6px; padding-bottom: 2px;">{{ 'Rp. ' . number_format($pesanan->booking->pelunasan, 0, ',', '.') ?? '-' }}</td>
                            @else
                                <td style="text-align: right; padding-top: 6px; padding-bottom: 2px;">{{ $pesanan->booking->pelunasan ? 'DP' : 'DP' }}:</td>
                                <td style="text-align: right; padding-top: 6px; padding-bottom: 2px;">{{ 'Rp. ' . number_format($pesanan->booking->dp, 0, ',', '.') ?? '-' }}</td>
                            @endif
                        </tr>
                    </table>
                    <div style="background-color: #f0f2f2; padding: 10px; margin-top: 10px;">
                        <div style="font-size: 16px; text-align: left">Jumlah yang Harus Dibayar</div>
                        @if ($pesanan->booking->pelunasan)
                            <div style="font-size: 24px;"><strong>{{ 'Rp. ' . number_format($jumlahSeluruh - ($pesanan->booking->pelunasan + $pesanan->discount), 0, ',', '.') ?? '-' }}</strong></div>
                        @else
                            <div style="font-size: 24px;"><strong>{{ 'Rp. ' . number_format($jumlahSeluruh - ($pesanan->booking->dp + $pesanan->discount), 0, ',', '.') ?? '-' }}</strong></div>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    </table>

    @php
        $jam_mulai = \Carbon\Carbon::parse($pesanan->booking->jam);
        $jam_selesai = \Carbon\Carbon::parse($pesanan->booking->jam_selesai);

        $selisih_menit = $jam_mulai->diffInMinutes($jam_selesai);
        $jam = floor($selisih_menit / 60); // Ambil jumlah jam dari menit
        $menit = $selisih_menit % 60; // Sisa menit setelah dikonversi ke jam
    @endphp 

    <div class="dp-info">
        <strong style="text-decoration: underline;">Catatan :</strong><br>
        - {{ $pesanan->booking->universitas }}<br>
        - Tanggal {{ $formattedDate = \Carbon\Carbon::parse($pesanan->booking->tanggal)->translatedFormat('d F Y') }}<br>
        - {{ $jam . ' ' . ' jam ' . $menit . ' Menit ' . 'foto di Lokasi Fakultas ' . $pesanan->booking->fakultas }}<br>
        - {{ $pesanan->booking->lokasi_foto }}
    </div>
</body>
</html>
