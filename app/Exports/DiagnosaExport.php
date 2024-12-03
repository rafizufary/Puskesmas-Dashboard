<?php

namespace App\Exports;

use App\Models\Penyakit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Auth;

class DiagnosaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $data;
    protected $namapoli;

    public function __construct($data, $namapoli)
    {
        $this->data = $data;
        $this->namapoli = $namapoli;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        // Tentukan judul kolom
        return [
            ['Data Diagnosa Penyakit'],
            ['Nama Poli', 'Kode Diagnosa', 'Nama Diagnosa']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $range = 'A1:C' . (count($this->collection()) + 2); // Menghitung jumlah baris data

        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle('thin');

        return [];
    }
}
?>