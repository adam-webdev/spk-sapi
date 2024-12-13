<?php

namespace App\Http\Controllers;

use App\Models\Sapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuzzyTahaniController extends Controller
{
    public function index()
    {



        $data = DB::table('sapis')->select('jenis_sapi', 'berat', 'umur')->get();

        $result = [];

        foreach ($data as $item) {

            $result[] = [
                'jenis_sapi' => $item->jenis_sapi,
                'bobot_asli' => $item->berat,
                'umur_asli' => $item->umur,
                'keanggotaan_berat' => $this->keanggotaanBobot($item->berat),
                'keangotaan_umur' => $this->keanggotaanUmur($item->umur),
            ];
        }

        return view('algoritma.ftahani.index', compact('result'));
    }

    public function create()
    {
        $sapi = DB::table('sapis')->distinct()->get('jenis_sapi');
        return view('algoritma.ftahani.ftahani', compact('sapi'));
    }

    public function store(Request $request)
    {
        $jenis = $request->jenis_sapi;
        $berat = $request->berat;
        $umur = $request->umur;

        $hasilfcm = DB::table('hasilfcm')->where('id', 1)->first();
        $hasilCluster = json_decode($hasilfcm->hasil_cluster);

        $datasetsapi = DB::table('dataset_sapis')
            ->join('sapis', 'dataset_sapis.x_sapi_id', '=', 'sapis.id')
            ->select('sapis.jenis_sapi', 'sapis.berat', 'sapis.umur', 'sapis.id')
            ->where('sapis.jenis_sapi', $jenis)
            ->get();

        $data = [];

        foreach ($datasetsapi as $key => $value) {

            // jika sapi berkualitas
            if ($hasilCluster[$key] == 2) {
                $data[] = [
                    'id' => $datasetsapi[$key]->id,
                    'jenis_sapi' => $datasetsapi[$key]->jenis_sapi,
                    'umur' => $datasetsapi[$key]->umur,
                    'berat' => $datasetsapi[$key]->berat,
                    'cluster' => $hasilCluster[$key],
                ];
            }
        }

        $result = [];

        $nilaiTengah = 0.5;

        foreach ($data as $item) {
            if ($this->keanggotaanBobot($item['berat'])[$berat] >= $nilaiTengah && $this->keanggotaanUmur($item['umur'])[$umur] >= $nilaiTengah) {
                $result[] = [
                    'id' => $item['id'],
                    'jenis_sapi' => $item['jenis_sapi'],
                    'bobot_asli' => $item['berat'],
                    'umur_asli' => $item['umur'],
                    'keanggotaan_berat' => $this->keanggotaanBobot($item['berat']),
                    'keangotaan_umur' => $this->keanggotaanUmur($item['umur']),
                ];
            }
        }
        return view('algoritma.ftahani.hasil', compact('result', 'jenis', 'berat', 'umur'));
    }

    public function hitungKeanggotaan(Request $request)
    {
        $data = Sapi::all();

        $result = [];

        foreach ($data as $item) {

            $result[] = [
                'jenis' => $item['jenis_sapi'],
                'bobot_asli' => $item['berat'],
                'umur_asli' => $item['umur'],
                'keanggotaan_berat' => $this->keanggotaanBobot($item['berat']),
                'keangotaan_umur' => $this->keanggotaanUmur($item['umur']),
            ];
        }

        return response()->json($result);
    }

    private function keanggotaanBobot($x)
    {
        $keanggotaan = [
            'ringan' => 0,
            'sedang' => 0,
            'berat' => 0
        ];

        // Ringan
        if ($x <= 200) {
            $keanggotaan['ringan'] = 1;
        } elseif ($x > 200 && $x <= 300) {
            $keanggotaan['ringan'] = (300 - $x) / 100;
            $keanggotaan['sedang'] = ($x - 200) / 100;
        }

        // Sedang
        if ($x > 200 && $x <= 300) {
            $keanggotaan['sedang'] = ($x - 200) / 100;
            $keanggotaan['ringan'] = (300 - $x) / 100;
        } elseif ($x > 300 && $x <= 400) {
            $keanggotaan['sedang'] = (400 - $x) / 100;
            $keanggotaan['berat'] = ($x - 300) / 100;
        }

        // Berat
        if ($x >= 400) {
            $keanggotaan['berat'] = 1;
        } elseif ($x > 300 && $x <= 400) {
            $keanggotaan['berat'] = ($x - 300) / 100;
            $keanggotaan['sedang'] = (400 - $x) / 100;
        }

        return $keanggotaan;
    }

    private function keanggotaanUmur($x)
    {
        $keanggotaan = [
            'muda' => 0,
            'dewasa' => 0,
            'tua' => 0
        ];

        // Muda
        if ($x <= 12) {
            $keanggotaan['muda'] = 1;
        } elseif ($x > 12 && $x <= 24) {
            $keanggotaan['muda'] = (24 - $x) / 12;
            $keanggotaan['dewasa'] = ($x - 12) / 12;
        }

        // Dewasa
        if ($x > 12 && $x <= 24) {
            $keanggotaan['dewasa'] = ($x - 12) / 12;
            $keanggotaan['muda'] = (24 - $x) / 12;
        } elseif ($x > 24 && $x <= 48) {
            $keanggotaan['dewasa'] = ($x - 24) / 24;
            $keanggotaan['tua'] = (48 - $x) / 24;
        }

        // Tua
        if ($x > 48) {
            $keanggotaan['tua'] = 1;
        } elseif ($x > 24 && $x <= 48) {
            $keanggotaan['tua'] = ($x - 24) / 24;
            $keanggotaan['dewasa'] = (48 - $x) / 24;
        }

        return $keanggotaan;
    }
}