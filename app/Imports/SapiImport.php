<?php

namespace App\Imports;

use App\Models\Sapi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class SapiImport implements ToModel, WithStartRow, WithHeadings, WithUpserts, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    public function rules(): array
    {
        return [
            '0' => 'string',
            '1' => function ($attr, $value, $onFailure) {
                if (!is_int($value)) {
                    $onFailure("Umur harus angka !");
                }
            },
            '2' => 'string',
            '3' => 'string',
            '4' => 'string',
            '5' => 'string',
            '6' => 'string',
            '7' => 'string',
            '8' => 'string',
            '9' => 'string',
            '10' => 'string',
            '11' => 'string',
            '12' => 'string'
            // '13' => 'string'
        ];
    }

    public function headings(): array
    {
        return ['Kode', 'Jenis', 'Umur', 'Jenis Kelamin', 'Berat', 'Kondisi Mulut', 'Kepala', 'Leher Bergelambir', 'Punggung Datar', 'Ekor Tidak Ada Legokan', 'Kaki Tegak Besar', 'Kondisi Gigi Lengkap', 'Kondisi Mata Normal', 'aksi'];
    }


    public function model(array $row)
    {
        if ($row[13] == 'delete') {
            Sapi::where('kode_sapi', $row[0])->delete();
        } else {
            return new Sapi([
                'kode_sapi' => $row[0],
                'jenis_sapi' => $row[1],
                'umur' => $row[2],
                'jenis_kelamin' => $row[3],
                'berat' => $row[4],
                'kondisi_mulut_datar' => $row[5],
                'kepala' => $row[6],
                'leher_bergelambir' => $row[7],
                'punggung_datar' => $row[8],
                'ekor_tidak_ada_legokan' => $row[9],
                'kaki_tegak_besar' => $row[10],
                'kondisi_gigi_lengkap' => $row[11],
                'kondisi_mata_normal' => $row[12],
            ]);
        }
    }
}
