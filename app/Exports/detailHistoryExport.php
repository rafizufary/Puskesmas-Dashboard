<?php

namespace App\Exports;

use App\Models\Rawatjalan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class detailHistoryExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{

    protected $data;
    protected $nama_pasien;

    public function __construct($data, $nama_pasien)
    {
        $this->data = $data;
        $this->nama_pasien = $nama_pasien;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        // Tentukan judul kolom
        return [
            ['Detail History Rawat Jalan '. $this->nama_pasien],
            ['Nama Pasien', 'Nama Diagnosa','Poli', 'Tanggal Periksa', 'Tanggal Control']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $range = 'A1:E' . (count($this->collection()) + 2); // Menghitung jumlah baris data

        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle('thin');

        return [];
    }
}
?>