<?php

namespace App\Imports;

use App\Models\SapiTesting;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SapiTestingImports implements ToModel, WithStartRow
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
        return 2;
    }



    public function uniqueBy()
    {
        return 'no';
    }
    // public function headings(): array
    // {
    //     return ['Kode', 'Jenis', 'Umur', 'Jenis Kelamin', 'Berat', 'Kondisi Mulut', 'Kepala', 'Leher Bergelambir', 'Punggung Datar', 'Ekor Tidak Ada Legokan', 'Kaki Tegak Besar', 'Kondisi Gigi Lengkap', 'Kondisi Mata Normal', 'aksi'];
    // }


    public function model(array $row)
    {
        // if ($row[13] == 'delete') {
        //     Sapi::where('id', $row[0])->delete();
        // } else {
        return new SapiTesting([
            'jenis_sapi' => $row[1],
            'umur' => $row[2],
            // 'jenis_kelamin' => $row[3],
            'berat' => $row[3],
            'kondisi_mulut_datar' => $row[4],
            // 'kepala' => $row[6],
            // 'leher_bergelambir' => $row[7],
            'punggung_datar' => $row[5],
            // 'ekor_tidak_ada_legokan' => $row[9],
            // 'kaki_tegak_besar' => $row[10],
            'kondisi_gigi_lengkap' => $row[6],
            'kondisi_mata_normal' => $row[7],
        ]);
        // }
    }
}