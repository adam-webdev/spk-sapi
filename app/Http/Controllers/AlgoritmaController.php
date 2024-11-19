<?php

namespace App\Http\Controllers;

use App\Models\Sapi;
use App\Models\SapiTesting;
use Illuminate\Http\Request;

class AlgoritmaController extends Controller
{
    public function fcm()
    {
        $data = [
            [
                'name' => 'Data Testing',
                'value' => 'data_testing',
                'jumlah_data' => SapiTesting::count(),
            ],
            [
                'name' => 'Data Sapi',
                'value' => 'data_sapi',
                'jumlah_data' => Sapi::count()
            ]
        ];
        return view('algoritma.fcm', compact('data'));
    }

    public function ftahani()
    {
        return view('algoritma.ftahani');
    }
}