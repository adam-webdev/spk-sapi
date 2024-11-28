<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HasilFcmSapi implements FromArray, WithHeadings
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }
    public function headings(): array
    {
        return [
            'Cluster ID',
            'Jenis Sapi',
            'Umur',
            'Jenis Kelamin',
            'Berat',
            'Kondisi Mulut Datar',
            'Kepala',
            'Leher Bergelambir',
            'Punggung Datar',
            'Ekor Tidak Ada Legokan',
            'Kaki Tegak Besar',
            'Kondisi Gigi Lengkap',
            'Kondisi Mata Normal',
            'Hasil Cluster'
        ];
    }
}
