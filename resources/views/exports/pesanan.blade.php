<!DOCTYPE html>
<html>
<head>
    <style>
        /* Gaya umum untuk tabel */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Style untuk baris pertama (judul) */
        .title-row td {
            font-weight: bold;
            text-align: center;
            background-color: #0070C0;
            color: #FFFFFF;
            padding: 10px;
            border: 1px solid #000;
        }

        /* Style untuk header tabel */
        th {
            background-color: #0070C0;
            color: #FFFFFF;
            font-weight: bold;
            text-align: center;
            padding: 8px;
            border: 1px solid black;
        }

        /* Style untuk isi tabel */
        td {
            text-align: center;
            padding: 5px;
            border: 1px solid black;
            vertical-align: middle;
        }

        /* Style untuk seluruh kolom otomatis */
        .auto-width th, .auto-width td {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <table>
        <!-- Baris Judul -->
        @if ($bulan)
        @php
            $formattedBulan = date('F Y', strtotime($bulan)); // Format menjadi "January 2025"
            $formattedBulan = str_replace(
                ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                $formattedBulan
            );
        @endphp
        <tr class="title-row">
            <td colspan="21">Laporan Bulan {{ $formattedBulan }}</td>
        </tr>
        @else
        <tr class="title-row">
            <td colspan="21">Laporan Keseluruhan</td>
        </tr>
        @endif
        <!-- Header -->
        <tr>
            <th>NO</th>
            <th>TANGGAL</th>
            <th>NEGARA</th>
            <th>KOTA</th>
            <th>UNIVERSITAS / VENUE</th>
            <th>NAMA</th>
            <th>NOMOR WA</th>
            <th>WAKTU</th>
            <th>PAKET</th>
            <th>FOTOGRAFER</th>
            <th>FAKULTAS</th>
            <th>LOKASI FOTO</th>
            <th>UPLOAD IG</th>
            <th>KETERANGAN</th>
            <th>STATUS FOTO</th>
            <th>HARGA</th>
            <th>DP</th>
            <th>KEKURANGAN</th>
            <th>PELUNASAN</th>
            <th>TOTAL</th>
            <th>FREELANCE</th>
        </tr>
        <!-- Data -->
        @foreach ($pesanan as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($data->booking->tanggal)->translatedFormat('d F Y') }}</td>
                <td>{{ $data->booking->negara }}</td>
                <td>{{ $data->booking->kota }}</td>
                <td>{{ $data->booking->universitas }}</td>
                <td>{{ $data->booking->nama }}</td>
                @php
                    $waNumber = $data->booking->no_wa;
                    // Cek apakah nomor WA dimulai dengan '0'
                    if (substr($waNumber, 0, 1) === '0') {
                        $waNumber = '62' . substr($waNumber, 1); // ganti awalan '0' jadi '62'
                    }
                @endphp
                <td>{{ $waNumber }}</td>
                <td>{{ $data->booking->jam }} - {{ $data->booking->jam_selesai }}</td>
                <td>{{ $data->booking->harga_paket->paket->kategori_paket->nama_kategori }} {{ $data->booking->harga_paket->paket->nama_paket }}</td>
                <td>{{ $data->fotografer->nama ?? '-' }}</td>
                <td>{{ $data->booking->fakultas }}</td>
                <td>{{ $data->booking->lokasi_foto }}</td>
                <td>{{ $data->booking->post_foto }}</td>
                <td>{{ $data->keterangan }}</td>
                <td>{{ $data->foto?->status_foto }}</td>
                <td>{{ 'Rp. ' . number_format($data->booking->harga_paket->harga, 0, ',', '.') }}</td>
                <td>{{ 'Rp. ' . number_format($data->booking->dp, 0, ',', '.') }}</td>
                <td>{{ 'Rp. ' . number_format($data->kekurangan, 0, ',', '.') }}</td>
                <td>{{ 'Rp. ' . number_format($data->pelunasan, 0, ',', '.') }}</td>
                <td>{{ 'Rp. ' . number_format($data->total, 0, ',', '.') }}</td>
                <td>{{ 'Rp. ' . number_format($data->freelance, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
