<?php

namespace App\Exports;

use App\Models\Pesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PesananExport implements WithStyles, FromView, ShouldAutoSize 
{
    // public function collection()
    // {
    //     return Pesanan::all();
    // }

    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $bulan = $this->bulan;
        
        $pesanan = Pesanan::whereHas('booking', function ($query) use ($bulan) {
            $query->where('status_booking', 'Accepted');

            // Jika bulan ada, filter berdasarkan bulan
            if ($bulan) {
                $query->whereYear('tanggal', date('Y', strtotime($bulan)))
                    ->whereMonth('tanggal', date('m', strtotime($bulan)));
            }
        })
        ->with(['booking.harga_paket.paket.kategori_paket', 'fotografer', 'foto'])
        ->get();
        
        return view('exports.pesanan', compact('pesanan', 'bulan'));
    }

    public function styles(Worksheet $sheet)
{
    // Style untuk judul (baris pertama)
    $sheet->getStyle('A1:U1')->applyFromArray([
        'alignment' => [
            'horizontal' => 'center',
            'vertical' => 'center',
        ],
        'font' => [
            'bold' => true,
            'size' => 16,
        ],
    ]);

    // Perbesar tinggi baris judul
    $sheet->getRowDimension(1)->setRowHeight(30);

    // Style untuk header (baris kedua)
    $sheet->getStyle('A2:U2')->applyFromArray([
        'font' => [
            'color' => ['argb' => 'FFFFFFFF'],
        ],
        'fill' => [
            'fillType' => 'solid',
            'startColor' => ['argb' => 'FF0070C0'],
        ],
        'alignment' => [
            'horizontal' => 'center',
            'vertical' => 'center',
        ],
    ]);

    // Perbesar tinggi baris header
    $sheet->getRowDimension(2)->setRowHeight(25);

    // Mengatur lebar kolom otomatis
    foreach (range('A', 'U') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Style untuk isi tabel (mulai dari baris ketiga hingga baris terakhir)
    $sheet->getStyle('A2:U' . ($sheet->getHighestRow()))->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
        'alignment' => [
            'horizontal' => 'center',
            'vertical' => 'center',
        ],
    ]);
}

}