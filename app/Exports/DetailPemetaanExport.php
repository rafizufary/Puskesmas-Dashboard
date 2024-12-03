<?php

namespace App\Exports;

use App\Models\Pasien;
use App\Models\RawatJalan as ModelsRawatJalan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\DB;
use App\Models\WebModel;

class DetailPemetaanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $data;
    protected $namapoli;
    protected $namaKecamatan;

    public function __construct($data, $namapoli, $namaKecamatan)
    {
        $this->data = $data;
        $this->namapoli = $namapoli;
        $this->kecamatan = $namaKecamatan;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        // Tentukan judul kolom
        return [
            ['Detail Persebaran Penyakit di kelurahan '. $this->kecamatan],
            ['Nama Penyakit', 'Total Penyakit']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1:B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $range = 'A1:B' . (count($this->collection()) + 2); // Menghitung jumlah baris data

        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle('thin');

        return [];
    }
}
?>