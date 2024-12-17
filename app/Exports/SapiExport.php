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


        return ['kode_sapi', 'jenis_sapi', 'umur_bulan', 'jenis_kelamin', 'bobot_kg',  'kondisi_mulut_datar_papak', 'kepala_sesuai_dengan_berat_badan_tdk', 'leher_bergelembir_tdk', 'punggung_datar_melengkung', 'ekor_tidak_ada_legokan', 'kaki_tegak_besar_tdk', 'kondisi_gigi_lengkap_tdk_lengkap', 'kondisi_mata_normal_berlendir_kelopak_mata_menurun'];
    }

    public function collection()
    {
        return Sapi::select('id', 'jenis_sapi', 'umur', 'berat', 'jenis_kelamin',  'kondisi_mulut_datar', 'kepala', 'leher_bergelambir', 'punggung_datar', 'ekor_tidak_ada_legokan', 'kaki_tegak_besar', 'kondisi_gigi_lengkap', 'kondisi_mata_normal')->get();
    }
}