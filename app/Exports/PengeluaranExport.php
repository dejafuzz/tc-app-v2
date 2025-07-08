<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use App\Models\Pesanan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengeluaranExport implements WithStyles, FromView, ShouldAutoSize 
{
    protected $bulan;

    public function __construct($bulan = null)
    {
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $pengeluaran = Pengeluaran::with('jenis_pengeluaran')
            ->when($this->bulan, function ($query) {
                $query->whereMonth('tanggal_transaksi', date('m', strtotime($this->bulan)))
                    ->whereYear('tanggal_transaksi', date('Y', strtotime($this->bulan)));
            })
            ->get();
        
        $totalOmsetKotor = Pesanan::where('status_pembayaran', 'Lunas')->sum('total');

        return view('exports.pengeluaran', [
            'pengeluaran' => $pengeluaran,
            'bulan' => $this->bulan,
            'totalOmsetKotor' => $totalOmsetKotor
        ]);
    }

    public function styles(Worksheet $sheet)
{
    // Style untuk judul (baris pertama)
    $sheet->getStyle('A1:E1')->applyFromArray([
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
    $sheet->getStyle('A2:E2')->applyFromArray([
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
    foreach (range('A', 'E') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Style untuk isi tabel (mulai dari baris ketiga hingga baris terakhir)
    $sheet->getStyle('A2:E' . ($sheet->getHighestRow()))->applyFromArray([
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
