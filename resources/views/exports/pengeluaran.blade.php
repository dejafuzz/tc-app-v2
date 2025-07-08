<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        .title-row td {
            font-weight: bold;
            text-align: center;
            background-color: #0070C0;
            color: #FFFFFF;
            padding: 10px;
            border: 1px solid #000;
        }

        th {
            background-color: #0070C0;
            color: #FFFFFF;
            font-weight: bold;
            text-align: center;
            padding: 8px;
            border: 1px solid black;
        }

        td {
            text-align: center;
            padding: 5px;
            border: 1px solid black;
            vertical-align: middle;
        }

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
                $formattedBulan = date('F Y', strtotime($bulan));
                $formattedBulan = str_replace(
                    ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    $formattedBulan
                );
            @endphp
            <tr class="title-row">
                <td colspan="5">Laporan Pengeluaran Bulan {{ $formattedBulan }}</td>
            </tr>
        @else
            <tr class="title-row">
                <td colspan="5">Laporan Pengeluaran Keseluruhan</td>
            </tr>
        @endif

        <!-- Header -->
        <tr>
            <th>NO</th>
            <th>JENIS PENGELUARAN</th>
            <th>TANGGAL TRANSAKSI</th>
            <th>DESKRIPSI</th>
            <th>NOMINAL</th>
        </tr>

        <!-- Data -->
        @php
            $totalPengeluaran = 0;
        @endphp
        @foreach ($pengeluaran as $key => $data)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $data->jenis_pengeluaran->jenis_pengeluaran ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($data->tanggal_transaksi)->format('d-m-Y') }}</td>
            <td>{{ $data->deskripsi }}</td>
            <td>{{ 'Rp. ' . number_format($data->nominal, 0, ',', '.') }}</td>
        </tr>
        @php
            $totalPengeluaran += $data->nominal;
        @endphp
        @endforeach

        @php
            $totalOmsetBersih = $totalOmsetKotor - $totalPengeluaran;
        @endphp
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">OMSET KOTOR</td>
            <td style="font-weight: bold;">{{ 'Rp. ' . number_format($totalOmsetKotor ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">TOTAL PENGELUARAN</td>
            <td style="font-weight: bold;">{{ 'Rp. ' . number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">OMSET BERSIH</td>
            <td style="font-weight: bold;">{{ 'Rp. ' . number_format($totalOmsetBersih ?? 0, 0, ',', '.') }}</td>
        </tr>
        
    </table>
</body>
</html>
