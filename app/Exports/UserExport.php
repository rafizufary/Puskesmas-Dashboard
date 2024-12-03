<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class UserExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        // 

        $data = User::select('name', 'email', 'level')->get();
                        

        return $data;
    }

    public function headings(): array
    {
        // Tentukan judul kolom
        return [
            ['Data User di Puskesmas Kecamatan Pesanggrahan'],
            ['Nama', 'Email', 'Role']
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