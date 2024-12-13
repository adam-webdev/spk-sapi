<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SapiTesting extends Model
{
    protected $table = 'sapi_testings';
    protected $fillable = ['id', 'jenis_sapi', 'umur', 'jenis_kelamin', 'berat', 'kondisi_mulut_datar', 'kepala', 'leher_bergelambir', 'punggung_datar', 'ekor_tidak_ada_legokan', 'kaki_tegak_besar', 'kondisi_gigi_lengkap', 'kondisi_mata_normal'];
}