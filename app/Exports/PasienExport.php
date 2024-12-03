<?php

namespace App\Exports;

use App\Models\Pasien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Auth;

class PasienExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStyles
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
        $headings = [];

        if (auth()->user()->level != 'super_admin') {
            $headings[] = ['Data Pasien di Poli ' . $this->namapoli . ' di Puskesmas Kecamatan Pesanggrahan'];
        } else {
            $headings[] = ['Data Pasien Keseluruhan di Puskesmas Kecamatan Pesanggrahan'];
        }

        $headings[] = ['Nik', 'Nama Pasien', 'Jenis Kelamin', 'Tanggal Lahir', 'Alamat', 'RT', 'RW', 'Provinsi', 'Kota/Kabupaten', 'Kecamatan', 'Kelurahan', 'No Telepon', 'No BPJS'];

        return $headings;
    }
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT,
            'K' => NumberFormat::FORMAT_TEXT,
            'L' => NumberFormat::FORMAT_NUMBER,
            'M' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:M1');
        $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $range = 'A1:M' . (count($this->collection()) + 2); // Menghitung jumlah baris data

        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle('thin');

        return [];
    }
}
?>