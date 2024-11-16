<?php

namespace App\Exports;

use App\Models\Sapi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SapiExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */



    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true]
            ],
        ];
    }
    public function map($row): array
    {
        $columnCek = ['jenis_kelamin', 'kondisi_mulut_datar', 'kepala', 'leher_bergelambir', 'punggung_datar', 'ekor_tidak_ada_legokan', 'kaki_tegak_besar', 'kondisi_gigi_lengkap', 'kondisi_mata_normal'];

        $data =  [
            $row->id,
            $row->jenis_sapi,
            $row->umur,
            $row->berat,
        ];

        foreach ($columnCek as $key => $column) {
            $data[] = $row->$column === 0 ? '0' : $row->$column;
        }

        return $data;
    }

    public function headings(): array
    {

        return ['Kode Sapi', 'Jenis Sapi', 'Umur', 'Berat', 'Jenis Kelamin',  'Kondisi Mulut', 'Kepala', 'Leher Bergelambir', 'Punggung Datar', 'Ekor Tidak Ada Legokan', 'Kaki Tegak Besar', 'Kondisi Gigi Lengkap', 'Kondisi Mata Normal'];
    }

    public function collection()
    {
        return Sapi::select('id', 'jenis_sapi', 'umur', 'berat', 'jenis_kelamin',  'kondisi_mulut_datar', 'kepala', 'leher_bergelambir', 'punggung_datar', 'ekor_tidak_ada_legokan', 'kaki_tegak_besar', 'kondisi_gigi_lengkap', 'kondisi_mata_normal')->get();
    }
}
