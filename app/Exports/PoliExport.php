<?php

namespace App\Exports;

use App\Models\Poli;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PoliExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        // 

        $data = Poli::select('kode_poli', 'nama_poli')->get();
                        

        return $data;
    }

    public function headings(): array
    {
        // Tentukan judul kolom
        return [
            ['Poli Di Puskesmas Kecamatan Pesanggrahan'],
            ['Kode Poli', 'Nama Poli']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:B1');
        $range = 'A1:B' . (count($this->collection()) + 2); // Menghitung jumlah baris data

        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle('thin');

        return [];
    }
}
?>