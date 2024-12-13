<?php

namespace App\Http\Controllers;

use App\Exports\HasilFcmSapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FCMController extends Controller
{

    public function fcm()
    {
        return view('algoritma.fcm.fcm');
    }
    public function index()
    {
        //
        $hasilfcm = DB::table('hasilfcm')->orderBy('created_at', 'desc')->get();
        return view('algoritma.fcm.index', compact('hasilfcm'));
    }

    public function detail($id)
    {

        $hasilfcm = DB::table('hasilfcm')->where('id', $id)->first();

        $datasetsapi = DB::table('dataset_sapis')
            ->join('sapis', 'dataset_sapis.x_sapi_id', '=', 'sapis.id')
            ->get();

        // cluster untuk graphic
        $dataCluster = array_count_values(json_decode($hasilfcm->hasil_cluster));

        return view('algoritma.fcm.detail', compact('hasilfcm', 'datasetsapi', 'dataCluster'));
    }


    public function exportHasilFcm($id, $format)
    {
        $hasilfcm = DB::table('hasilfcm')->where('id', $id)->first();

        $datasetsapi = DB::table('dataset_sapis')
            ->join('sapis', 'dataset_sapis.x_sapi_id', '=', 'sapis.id')
            ->get();

        // Decode hasil cluster
        $hasilCluster = json_decode($hasilfcm->hasil_cluster);
        // Siapkan data untuk export
        $dataForExport = [];
        foreach ($hasilCluster as $key => $value) {
            $dataForExport[] = [
                'Cluster ID' => 'C' . str_pad($key + 1, 4, '0', STR_PAD_LEFT),
                'Jenis Sapi' => $datasetsapi[$key]->jenis_sapi,
                'Umur' => $datasetsapi[$key]->umur,
                'Jenis Kelamin' => $datasetsapi[$key]->jenis_kelamin,
                'Berat' => $datasetsapi[$key]->berat,
                'Kondisi Mulut Datar' => $datasetsapi[$key]->kondisi_mulut_datar,
                'Kepala' => $datasetsapi[$key]->kepala,
                'Leher Bergelambir' => $datasetsapi[$key]->leher_bergelambir,
                'Punggung Datar' => $datasetsapi[$key]->punggung_datar,
                'Ekor Tidak Ada Legokan' => $datasetsapi[$key]->ekor_tidak_ada_legokan,
                'Kaki Tegak Besar' => $datasetsapi[$key]->kaki_tegak_besar,
                'Kondisi Gigi Lengkap' => $datasetsapi[$key]->kondisi_gigi_lengkap,
                'Kondisi Mata Normal' => $datasetsapi[$key]->kondisi_mata_normal,
                'Hasil Cluster' => $value .  " " .  ($value == 2 ? "( Berkualitas" : "Tidak Berkualitas") . ")",
            ];
        }
        $format = request('format', 'xlsx'); // Default format adalah xlsx
        // Pilih format export
        $fileName = 'hasil_fcm_sapi.' . $format;
        $export = new HasilFcmSapi($dataForExport);

        // Export berdasarkan format
        if ($format === 'csv') {
            return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::CSV);
        } elseif ($format === 'xlsx') {
            return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX);
        } else {
            abort(400, 'Format not supported');
        }
    }
    public function prosesFCM(Request $request)
    {
        $jumlahCluster = $request->cluster;
        // $m = $request->fuzziness;
        $maksIter = $request->max_iter;
        $epsilon = $request->epsilon;

        $dataset = DB::table('dataset_sapis')->get();


        $matriksPartAwal = $this->matriksPartisiAwal($jumlahCluster, count($dataset));

        //        var_dump($matriksPartAwal);

        $matriksPartU = [];
        $p[0] = 0;
        $fungsiObjektif = [];
        $error = [];

        for ($j = 0; $j < $maksIter; $j++) {
            $p[$j + 1] = 0;
            if ($j == 0) {
                $c = [];
                $sumC = [];
                $pusatC = [];

                $L = [];
                $sumL = [];

                $ML = [];
                $sumML = [];

                for ($i = 0; $i < $jumlahCluster; $i++) {
                    foreach ($dataset as $key => $value) {
                        $mu2 = pow(str_replace(',', '.', $matriksPartAwal[$key][$i]), 2);
                        $c[$i][$key] = [
                            '𝝁i^2' => $mu2,
                            '𝝁i^2*x1' => $mu2 * $value->x1,
                            '𝝁i^2*x2' => $mu2 * $value->x2,
                            '𝝁i^2*x3' => $mu2 * $value->x3,
                            '𝝁i^2*x4' => $mu2 * $value->x4,
                            '𝝁i^2*x5' => $mu2 * $value->x5,
                            '𝝁i^2*x6' => $mu2 * $value->x6,
                            '𝝁i^2*x7' => $mu2 * $value->x7,
                            '𝝁i^2*x8' => $mu2 * $value->x8,
                            '𝝁i^2*x9' => $mu2 * $value->x9,
                            '𝝁i^2*x10' => $mu2 * $value->x10,
                            '𝝁i^2*x11' => $mu2 * $value->x11,

                        ];
                        $sumC[$i] = [
                            '∑𝝁i^2' => 0,
                            '∑𝝁i^2*x1' => 0,
                            '∑𝝁i^2*x2' => 0,
                            '∑𝝁i^2*x3' => 0,
                            '∑𝝁i^2*x4' => 0,
                            '∑𝝁i^2*x5' => 0,
                            '∑𝝁i^2*x6' => 0,
                            '∑𝝁i^2*x7' => 0,
                            '∑𝝁i^2*x8' => 0,
                            '∑𝝁i^2*x9' => 0,
                            '∑𝝁i^2*x10' => 0,
                            '∑𝝁i^2*x11' => 0,

                        ];
                    }
                }

                for ($i = 0; $i < $jumlahCluster; $i++) {
                    foreach ($dataset as $key => $value) {
                        $sumC[$i]['∑𝝁i^2'] += $c[$i][$key]['𝝁i^2'];
                        $sumC[$i]['∑𝝁i^2*x1'] += $c[$i][$key]['𝝁i^2*x1'];
                        $sumC[$i]['∑𝝁i^2*x2'] += $c[$i][$key]['𝝁i^2*x2'];
                        $sumC[$i]['∑𝝁i^2*x3'] += $c[$i][$key]['𝝁i^2*x3'];
                        $sumC[$i]['∑𝝁i^2*x4'] += $c[$i][$key]['𝝁i^2*x4'];
                        $sumC[$i]['∑𝝁i^2*x5'] += $c[$i][$key]['𝝁i^2*x5'];
                        $sumC[$i]['∑𝝁i^2*x6'] += $c[$i][$key]['𝝁i^2*x6'];
                        $sumC[$i]['∑𝝁i^2*x7'] += $c[$i][$key]['𝝁i^2*x7'];
                        $sumC[$i]['∑𝝁i^2*x8'] += $c[$i][$key]['𝝁i^2*x8'];
                        $sumC[$i]['∑𝝁i^2*x9'] += $c[$i][$key]['𝝁i^2*x9'];
                        $sumC[$i]['∑𝝁i^2*x10'] += $c[$i][$key]['𝝁i^2*x10'];
                        $sumC[$i]['∑𝝁i^2*x11'] += $c[$i][$key]['𝝁i^2*x11'];
                    }

                    $pusatC[$i]['∑𝝁i^2*x1'] = $sumC[$i]['∑𝝁i^2*x1'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x2'] = $sumC[$i]['∑𝝁i^2*x2'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x3'] = $sumC[$i]['∑𝝁i^2*x3'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x4'] = $sumC[$i]['∑𝝁i^2*x4'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x5'] = $sumC[$i]['∑𝝁i^2*x5'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x6'] = $sumC[$i]['∑𝝁i^2*x6'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x7'] = $sumC[$i]['∑𝝁i^2*x7'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x8'] = $sumC[$i]['∑𝝁i^2*x8'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x9'] = $sumC[$i]['∑𝝁i^2*x9'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x10'] = $sumC[$i]['∑𝝁i^2*x10'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x11'] = $sumC[$i]['∑𝝁i^2*x11'] / $sumC[$i]['∑𝝁i^2'];
                }

                foreach ($dataset as $key => $value) {
                    $sumL[$key] = 0;
                    $sumML[$key] = 0;
                }

                for ($i = 0; $i < $jumlahCluster; $i++) {
                    foreach ($dataset as $key => $value) {
                        $L[$i][$key] = (
                            (pow($value->x1 - $pusatC[$i]['∑𝝁i^2*x1'], 2)) +
                            (pow($value->x2 - $pusatC[$i]['∑𝝁i^2*x2'], 2)) +
                            (pow($value->x3 - $pusatC[$i]['∑𝝁i^2*x3'], 2)) +
                            (pow($value->x4 - $pusatC[$i]['∑𝝁i^2*x4'], 2)) +
                            (pow($value->x5 - $pusatC[$i]['∑𝝁i^2*x5'], 2)) +
                            (pow($value->x6 - $pusatC[$i]['∑𝝁i^2*x6'], 2)) +
                            (pow($value->x7 - $pusatC[$i]['∑𝝁i^2*x7'], 2)) +
                            (pow($value->x8 - $pusatC[$i]['∑𝝁i^2*x8'], 2)) +
                            (pow($value->x9 - $pusatC[$i]['∑𝝁i^2*x9'], 2)) +
                            (pow($value->x10 - $pusatC[$i]['∑𝝁i^2*x10'], 2)) +
                            (pow($value->x11 - $pusatC[$i]['∑𝝁i^2*x11'], 2))  *
                            $c[$i][$key]['𝝁i^2']
                        );

                        $sumL[$key] += $L[$i][$key];
                        $ML[$i][$key] = (pow((
                            (pow($value->x1 - $pusatC[$i]['∑𝝁i^2*x1'], 2)) +
                            (pow($value->x2 - $pusatC[$i]['∑𝝁i^2*x2'], 2)) +
                            (pow($value->x3 - $pusatC[$i]['∑𝝁i^2*x3'], 2)) +
                            (pow($value->x4 - $pusatC[$i]['∑𝝁i^2*x4'], 2)) +
                            (pow($value->x5 - $pusatC[$i]['∑𝝁i^2*x5'], 2)) +
                            (pow($value->x6 - $pusatC[$i]['∑𝝁i^2*x6'], 2)) +
                            (pow($value->x7 - $pusatC[$i]['∑𝝁i^2*x7'], 2)) +
                            (pow($value->x8 - $pusatC[$i]['∑𝝁i^2*x8'], 2)) +
                            (pow($value->x9 - $pusatC[$i]['∑𝝁i^2*x9'], 2)) +
                            (pow($value->x10 - $pusatC[$i]['∑𝝁i^2*x10'], 2)) +
                            (pow($value->x11 - $pusatC[$i]['∑𝝁i^2*x11'], 2))), -1)
                        );

                        $sumML[$key] += $ML[$i][$key];
                    }
                }

                for ($i = 0; $i < $jumlahCluster; $i++) {
                    foreach ($dataset as $key => $value) {
                        $matriksPartU[$i][$key] = $ML[$i][$key] / $sumML[$key];
                    }
                }

                foreach ($dataset as $key => $value) {
                    $p[$j + 1] += $sumL[$key];
                }
            } else {
                $c = [];
                $sumC = [];
                $pusatC = [];

                $L = [];
                $sumL = [];

                $ML = [];
                $sumML = [];

                for ($i = 0; $i < $jumlahCluster; $i++) {
                    foreach ($dataset as $key => $value) {
                        $mu2 = pow($matriksPartU[$i][$key], 2);

                        $c[$i][$key] = [
                            '𝝁i^2' => $mu2,
                            '𝝁i^2*x1' => $mu2 * $value->x1,
                            '𝝁i^2*x2' => $mu2 * $value->x2,
                            '𝝁i^2*x3' => $mu2 * $value->x3,
                            '𝝁i^2*x4' => $mu2 * $value->x4,
                            '𝝁i^2*x5' => $mu2 * $value->x5,
                            '𝝁i^2*x6' => $mu2 * $value->x6,
                            '𝝁i^2*x7' => $mu2 * $value->x7,
                            '𝝁i^2*x8' => $mu2 * $value->x8,
                            '𝝁i^2*x9' => $mu2 * $value->x9,
                            '𝝁i^2*x10' => $mu2 * $value->x10,
                            '𝝁i^2*x11' => $mu2 * $value->x11,
                        ];
                        $sumC[$i] = [
                            '∑𝝁i^2' => 0,
                            '∑𝝁i^2*x1' => 0,
                            '∑𝝁i^2*x2' => 0,
                            '∑𝝁i^2*x3' => 0,
                            '∑𝝁i^2*x4' => 0,
                            '∑𝝁i^2*x5' => 0,
                            '∑𝝁i^2*x6' => 0,
                            '∑𝝁i^2*x7' => 0,
                            '∑𝝁i^2*x8' => 0,
                            '∑𝝁i^2*x9' => 0,
                            '∑𝝁i^2*x10' => 0,
                            '∑𝝁i^2*x11' => 0,
                        ];
                    }
                }

                for ($i = 0; $i < $jumlahCluster; $i++) {
                    foreach ($dataset as $key => $value) {
                        $sumC[$i]['∑𝝁i^2'] += $c[$i][$key]['𝝁i^2'];
                        $sumC[$i]['∑𝝁i^2*x1'] += $c[$i][$key]['𝝁i^2*x1'];
                        $sumC[$i]['∑𝝁i^2*x2'] += $c[$i][$key]['𝝁i^2*x2'];
                        $sumC[$i]['∑𝝁i^2*x3'] += $c[$i][$key]['𝝁i^2*x3'];
                        $sumC[$i]['∑𝝁i^2*x4'] += $c[$i][$key]['𝝁i^2*x4'];
                        $sumC[$i]['∑𝝁i^2*x5'] += $c[$i][$key]['𝝁i^2*x5'];
                        $sumC[$i]['∑𝝁i^2*x6'] += $c[$i][$key]['𝝁i^2*x6'];
                        $sumC[$i]['∑𝝁i^2*x7'] += $c[$i][$key]['𝝁i^2*x7'];
                        $sumC[$i]['∑𝝁i^2*x8'] += $c[$i][$key]['𝝁i^2*x8'];
                        $sumC[$i]['∑𝝁i^2*x9'] += $c[$i][$key]['𝝁i^2*x9'];
                        $sumC[$i]['∑𝝁i^2*x10'] += $c[$i][$key]['𝝁i^2*x10'];
                        $sumC[$i]['∑𝝁i^2*x11'] += $c[$i][$key]['𝝁i^2*x11'];
                    }

                    $pusatC[$i]['∑𝝁i^2*x1'] = $sumC[$i]['∑𝝁i^2*x1'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x2'] = $sumC[$i]['∑𝝁i^2*x2'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x3'] = $sumC[$i]['∑𝝁i^2*x3'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x4'] = $sumC[$i]['∑𝝁i^2*x4'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x5'] = $sumC[$i]['∑𝝁i^2*x5'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x6'] = $sumC[$i]['∑𝝁i^2*x6'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x7'] = $sumC[$i]['∑𝝁i^2*x7'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x8'] = $sumC[$i]['∑𝝁i^2*x8'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x9'] = $sumC[$i]['∑𝝁i^2*x9'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x10'] = $sumC[$i]['∑𝝁i^2*x10'] / $sumC[$i]['∑𝝁i^2'];
                    $pusatC[$i]['∑𝝁i^2*x11'] = $sumC[$i]['∑𝝁i^2*x11'] / $sumC[$i]['∑𝝁i^2'];
                }

                foreach ($dataset as $key => $value) {
                    $sumL[$key] = 0;
                    $sumML[$key] = 0;
                }

                for ($i = 0; $i < $jumlahCluster; $i++) {
                    foreach ($dataset as $key => $value) {
                        $L[$i][$key] = (
                            (pow($value->x1 - $pusatC[$i]['∑𝝁i^2*x1'], 2)) +
                            (pow($value->x2 - $pusatC[$i]['∑𝝁i^2*x2'], 2)) +
                            (pow($value->x3 - $pusatC[$i]['∑𝝁i^2*x3'], 2)) +
                            (pow($value->x4 - $pusatC[$i]['∑𝝁i^2*x4'], 2)) +
                            (pow($value->x5 - $pusatC[$i]['∑𝝁i^2*x5'], 2)) +
                            (pow($value->x6 - $pusatC[$i]['∑𝝁i^2*x6'], 2)) +
                            (pow($value->x7 - $pusatC[$i]['∑𝝁i^2*x7'], 2)) +
                            (pow($value->x8 - $pusatC[$i]['∑𝝁i^2*x8'], 2)) +
                            (pow($value->x9 - $pusatC[$i]['∑𝝁i^2*x9'], 2)) +
                            (pow($value->x10 - $pusatC[$i]['∑𝝁i^2*x10'], 2)) +
                            (pow($value->x11 - $pusatC[$i]['∑𝝁i^2*x11'], 2))  *
                            $c[$i][$key]['𝝁i^2']
                        );

                        $sumL[$key] += $L[$i][$key];
                        $ML[$i][$key] = (pow((
                            (pow($value->x1 - $pusatC[$i]['∑𝝁i^2*x1'], 2)) +
                            (pow($value->x2 - $pusatC[$i]['∑𝝁i^2*x2'], 2)) +
                            (pow($value->x3 - $pusatC[$i]['∑𝝁i^2*x3'], 2)) +
                            (pow($value->x4 - $pusatC[$i]['∑𝝁i^2*x4'], 2)) +
                            (pow($value->x5 - $pusatC[$i]['∑𝝁i^2*x5'], 2)) +
                            (pow($value->x6 - $pusatC[$i]['∑𝝁i^2*x6'], 2)) +
                            (pow($value->x7 - $pusatC[$i]['∑𝝁i^2*x7'], 2)) +
                            (pow($value->x8 - $pusatC[$i]['∑𝝁i^2*x8'], 2)) +
                            (pow($value->x9 - $pusatC[$i]['∑𝝁i^2*x9'], 2)) +
                            (pow($value->x10 - $pusatC[$i]['∑𝝁i^2*x10'], 2)) +
                            (pow($value->x11 - $pusatC[$i]['∑𝝁i^2*x11'], 2))), -1)
                        );

                        $sumML[$key] += $ML[$i][$key];
                    }
                }

                for ($i = 0; $i < $jumlahCluster; $i++) {
                    foreach ($dataset as $key => $value) {
                        $matriksPartU[$i][$key] = $ML[$i][$key] / $sumML[$key];
                    }
                }

                foreach ($dataset as $key => $value) {
                    $p[$j + 1] += $sumL[$key];
                }
            }
            //            var_dump((number_format(abs($p[$j+1] - $p[$j]),15)));
            $fungsiObjektif[$j] = $p[$j + 1];
            $error[$j] = $p[$j + 1] - $p[$j];
            if ((abs($p[$j + 1] - $p[$j]) <= $epsilon)) {
                break;
            }
        }

        $hasilCluster = [];
        $hasilL = [];
        $hasilLT = [];

        for ($i = 0; $i < $jumlahCluster; $i++) {
            foreach ($dataset as $key => $value) {
                $hasilCluster[$key][$i] = $matriksPartU[$i][$key];
                $hasilL[$key][$i] = $L[$i][$key];
            }
        }

        $mHasilCluster = [];
        foreach ($dataset as $key => $value) {
            $mHasilCluster[$key] = (array_search(max($hasilCluster[$key]), $hasilCluster[$key])) + 1;
            $hasilLT[$key] = $sumL[$key];
        }



        $hasilfcm = [
            'hasil_jumlah_cluster' => $jumlahCluster,
            'hasil_iterasi' => $maksIter,
            'hasil_error_terkecil' => $epsilon,
            'hasil_hitung_cluster' => json_encode($hasilCluster),
            'hasil_L' => json_encode($hasilL),
            'hasil_LT' => json_encode($hasilLT),
            'hasil_cluster' => json_encode($mHasilCluster),
            'fungsi_objektif' => json_encode($fungsiObjektif),
            'error' => json_encode($error),
            'created_at' => now(),
            'updated_at' => now()
        ];

        //        dd($simpan);
        DB::table('hasilfcm')->insert($hasilfcm);

        return redirect()->route('fcm.data')->with('status', 'Data berhasil disimpan');
    }


    function matriksPartisiAwal($jumlahCluster, $jumlahData)
    {
        $matriks = [];
        if ($jumlahCluster == 2) {
            $data = DB::table('matriks_2')->get();
            for ($i = 0; $i < $jumlahData; $i++) {
                $matriks[$i] = [
                    $data[$i]->matriks_2_1,
                    $data[$i]->matriks_2_2,
                ];
            }
        } elseif ($jumlahCluster == 3) {
            $data = DB::table('matriks_3')->get();
            for ($i = 0; $i < $jumlahData; $i++) {
                $matriks[$i] = [
                    $data[$i]->matriks_3_1,
                    $data[$i]->matriks_3_2,
                    $data[$i]->matriks_3_3,
                ];
            }
        } elseif ($jumlahCluster == 4) {
            $data = DB::table('matriks_4')->get();
            for ($i = 0; $i < $jumlahData; $i++) {
                $matriks[$i] = [
                    $data[$i]->matriks_4_1,
                    $data[$i]->matriks_4_2,
                    $data[$i]->matriks_4_3,
                    $data[$i]->matriks_4_4,
                ];
            }
        }
        // elseif ($jumlahCluster == 5) {
        //     $data = DB::table('matriks_5')->get();
        //     for ($i = 0; $i < $jumlahData; $i++) {
        //         $matriks[$i] = [
        //             $data[$i]->matriks_5_1,
        //             $data[$i]->matriks_5_2,
        //             $data[$i]->matriks_5_3,
        //             $data[$i]->matriks_5_4,
        //             $data[$i]->matriks_5_5,
        //         ];
        //     }
        // }
        return $matriks;
    }
}
