<?php

namespace App\Imports;

use App\Models\Sapi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class SapiImport implements ToModel, WithStartRow, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    // public function rules(): array
    // {
    //     return [
    //         '0' => 'integer',
    //         '1' => 'string',
    //         '2' => function ($attr, $value, $onFailure) {
    //             if (!is_int($value)) {
    //                 $onFailure("Umur harus angka !");
    //             }
    //         },
    //         '3' => 'integer',
    //         '4' => 'integer',
    //         '5' => 'integer',
    //         '6' => 'integer',
    //         '7' => 'integer',
    //         '8' => 'integer',
    //         '9' => 'integer',
    //         '10' => 'integer',
    //         '11' => 'integer',
    //         '12' => 'integer'
    //         // '13' => 'string'
    //     ];
    // }
    public function startRow(): int
    {
        return 3;
    }



    public function uniqueBy()
    {
        return 'no';
    }
    // public function headings(): array
    // {
    //     return ['id', 'Jenis Sapi', 'Umur', 'Jenis Kelamin', 'Berat', 'Kondisi Mulut', 'Kepala', 'Leher Bergelambir', 'Punggung Datar', 'Ekor Tidak Ada Legokan', 'Kaki Tegak Besar', 'Kondisi Gigi Lengkap', 'Kondisi Mata Normal'];
    // }


    public function model(array $row)
    {
        // if ($row[13] == 'delete') {
        //     Sapi::where('id', $row[0])->delete();
        // } else {

        return new Sapi([
            'id' => $row['no'],
            'jenis_sapi' => $row['jenis_sapi'],
            'umur' => $row['umur_bulan'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'berat' => $row['bobot_kg'],
            'kondisi_mulut_datar' => $row['kondisi_mulut_datar_papak'],
            'kepala' => $row['kepala_sesuai_dengan_berat_badan_tdk'],
            'leher_bergelambir' => $row['leher_bergelembirtdk_bergelembir'],
            'punggung_datar' => $row['punggung_datarmelengkung'],
            'ekor_tidak_ada_legokan' => $row['ekor_tidak_ada_legokan'],
            'kaki_tegak_besar' => $row['kaki_tegak_besar_tdk'],
            'kondisi_gigi_lengkap' => $row['kondisi_gigi_lengkaptdk_lengkap'],
            'kondisi_mata_normal' => $row['kondisi_mata_normal_berlendir_kelopak_mata_menurun']
        ]);
        // }
    }
}
