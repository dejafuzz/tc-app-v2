<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Faktur#' . $pesanan->faktur . '#' . $pesanan->booking->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h2 {
            margin: 0;
        }
        .invoice-header p {
            margin: 5px 0;
            font-size: 12px;
        }

        .invoice-details {
            width: 50%; /* Lebar tabel */
            margin-bottom: 20px;
            float: right; /* Mengapung ke kanan */
        }

        .invoice-details td, .invoice-details th {
            padding: 5px;
        }

        .invoice-details th {
            text-align: left;
            width: 150px;
        }

        .invoice-details td {
            font-size: 12px;
        }

        .items, .payment-details {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .items th, .payment-details th, .items td, .payment-details td {
            border: 1px solid #000;
            padding: 5px;
        }

        .items th, .payment-details th {
            background-color: #f4f4f4;
            text-align: left;
        }

        .items td {
            text-align: left;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
            text-align: right;
            padding-top: 20px;
        }

        .dp-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #000;
        }

        .dp-table td {
            padding: 5px;
            font-size: 12px;
        }

        .dp-table th {
            padding: 5px;
        }

        .dp-table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h2>Tersimpan Cerita</h2>
        <p>Jalan Kertanegara Gang Dalem No. 22</p>
        <p>Banyumanik, Jawa Tengah 51222</p>
        <p>+6282131125632 | tersimpancerita@gmail.com</p>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <th style="text-align: right;">Faktur #</th>
                <th style="text-align: right;">Dikirim Kepada:</th>
            </tr>
            <tr>
                <td style="text-align: right;">{{ $pesanan->faktur }}</td>
                <td style="text-align: right;">
                    {{ 
                        $pesanan->booking->nama
                        . ', ' . 
                        $pesanan->booking->universitas
                    }}
                </td>
            </tr>
            <tr>
                <th style="text-align: right;">Tanggal</th>
                <th style="text-align: right;">Telepon:</th>
            </tr>
            <tr>
                <td style="text-align: right;">
                    {{ \Carbon\Carbon::parse($pesanan->booking?->tanggal_dp)->translatedFormat('d F Y') }}
                </td>
                <td style="text-align: right;">
                    @php
                        $waNumber = $pesanan->booking->no_wa;
                        if ($waNumber !== '-' && substr($waNumber, 0, 1) === '0') {
                            $waNumber = '+62' . substr($waNumber, 1);
                        }
                    @endphp
                    {{ $waNumber }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Clear float untuk memastikan elemen berikutnya tidak terpengaruh -->
    <div style="clear: both;"></div>

    <div class="items">
        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Kuantitas</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $kuantitas = 1;
                    $jumlahHargaTambahan = 0;
                    $total = $pesanan->booking->harga_paket->harga * $kuantitas;
                @endphp
                <tr>
                    <td style="font-weight: bolder">{{ $pesanan->booking->harga_paket->paket->kategori_paket->nama_kategori . ' ' . $pesanan->booking->harga_paket->paket->nama_paket . ' ' . $pesanan->booking->kota }}</td>
                    <td>1</td>
                    <td>{{ 'Rp ' . number_format($pesanan->booking->harga_paket->harga, 0, ',', '.') ?? '-' }}</td>
                    <td>{{ 'Rp ' . number_format($total, 0, ',', '.') ?? '-' }}</td>
                </tr>
                @php
                    $fiturs = json_decode($pesanan->booking->harga_paket->paket->fitur);
                @endphp
                @foreach ($fiturs as $item)
                    <tr>
                        <td>- {{ $item }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="font-weight: bold; text-align: center;">PAKET TAMBAHAN</td>
                </tr>
                @foreach ($pesanan->booking->bookingPaketTambahan as $item)
                    <tr>
                        <td>- {{ $item->paketTambahan->jenis_tambahan }}</td>
                        <td>1</td>
                        <td>{{ 'Rp ' . number_format($item->paketTambahan->harga_tambahan, 0, ',', '.') ?? '-' }}</td>
                        <td>{{ 'Rp ' . number_format($item->paketTambahan->harga_tambahan, 0, ',', '.') ?? '-' }}</td>
                    </tr>
                    @php
                        $jumlahHargaTambahan += $item->paketTambahan->harga_tambahan; 
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>

    @php
        $jumlahSeluruh = $total + $jumlahHargaTambahan;
        // dd($total);
    @endphp

    <div class="payment-details">
        <table>
            <thead>
                <tr>
                    <th>Instalasi Pembayaran</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bank Mandiri: 1480210148102349 (Al Ahmad Riza Rifqi Arsy A)</td>
                    <td>{{ 'Rp ' . number_format($jumlahSeluruh, 0, ',', '.') ?? '-' }}</td>
                    <td>{{ 'Rp ' . number_format($jumlahSeluruh, 0, ',', '.') ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="total">
        <p>Jumlah yang Harus Dibayar: {{ 'Rp ' . number_format($jumlahSeluruh - $pesanan->booking->dp, 0, ',', '.') ?? '-' }}</p>
    </div>

    <div class="dp-section">
        <table class="dp-table">
            <thead>
                <tr>
                    <th>DP : {{ 'Rp. ' . number_format($pesanan->booking->dp, 0, ',', '.') ?? '-' }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>- {{ $pesanan->booking->universitas }}</td>
                </tr>
                <tr>
                    <td>- Tanggal {{ $formattedDate = \Carbon\Carbon::parse($pesanan->booking->tanggal)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td>
                        @php
                            $jam_mulai = \Carbon\Carbon::parse($pesanan->booking->jam);
                            $jam_selesai = \Carbon\Carbon::parse($pesanan->booking->jam_selesai);

                            $selisih_menit = $jam_mulai->diffInMinutes($jam_selesai);
                            $jam = floor($selisih_menit / 60); // Ambil jumlah jam dari menit
                            $menit = $selisih_menit % 60; // Sisa menit setelah dikonversi ke jam
                        @endphp 
                        - {{ $jam . ' ' . ' jam ' . $menit . ' Menit ' . 'foto di Lokasi Fakultas ' . $pesanan->booking->fakultas }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>