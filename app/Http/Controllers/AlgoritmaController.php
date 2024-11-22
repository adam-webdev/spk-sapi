<?php

namespace App\Http\Controllers;

use App\Models\Sapi;
use App\Models\SapiTesting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    // jarak euclidean
    private function euclideanDistance($point, $centroid)
    {
        return sqrt(array_reduce(array_keys($point), fn($carry, $k) => $carry + pow($point[$k] - $centroid[$k], 2), 0));
    }
    // has converged
    private function hasConverged($newMatrix, $oldMatrix, $epsilon)
    {
        foreach ($newMatrix as $i => $row) {
            foreach ($row as $j => $value) {
                if (abs($value - $oldMatrix[$i][$j]) > $epsilon) {
                    return false;
                }
            }
        }
        return true;
        // dd('Converged', $newMatrix, $oldMatrix);


    }


    public function processFCM(Request $request)
    {
        $data_hitung = $request->data_hitung;
        $jumlah_cluster = $request->cluster;
        $m = $request->fuzziness;
        $max_iterasi = $request->max_iter;
        $epsilon = $request->epsilon;

        $data = [];

        if ($data_hitung == 'data_testing') {
            $data = SapiTesting::select(['umur', 'berat', 'kondisi_mulut_datar', 'punggung_datar', 'kondisi_gigi_lengkap', 'kondisi_mata_normal'])->get();
        } else {
            $data = Sapi::select(['umur', 'berat', 'kondisi_mulut_datar', 'punggung_datar', 'kondisi_gigi_lengkap', 'kondisi_mata_normal'])->get();
        }

        $dataArray = $data->map(function ($row) {
            return array_values($row->toArray());
        })->toArray();


        // inisialisasi keanggotan Matrix U
        $membershipMatrix = [];
        foreach ($dataArray as $i => $value) {
            // Generate random value between 0 and 1
            $randValue = mt_rand(1, 9) / 10; // Nilai acak dengan 1 angka di belakang koma (0.1 - 0.9)

            // Tentukan keanggotaan untuk cluster
            $membershipMatrix[$i][0] = round($randValue, 1); // Cluster 1
            $membershipMatrix[$i][1] = round(1 - $randValue, 1); // Cluster 2 (sisa dari 1)
        }
        // dd($membershipMatrix);

        $centroids = [];
        $iteration = 0;
        $objectiveFunction = 0;
        $changes = [];

        do {
            $iteration++;
            $oldMembershipMatrix = $membershipMatrix;

            // update centroids
            $centroids = [];
            for ($j = 0; $j < $jumlah_cluster; $j++) {
                $numerator = array_fill(0, count($dataArray[0]), 0);
                $denominator = 0;

                foreach ($dataArray as $i => $point) {
                    $uij_m = pow($membershipMatrix[$i][$j], $m);
                    foreach ($point as $k => $value) {
                        $numerator[$k] += $uij_m * $value;
                    }
                    $denominator += $uij_m;
                }

                $centroids[$j] = array_map(fn($value) => $value / $denominator, $numerator);
            }

            // 2. Update Matriks Keanggotaan
            foreach ($dataArray as $i => $point) {

                for ($j = 0; $j < $jumlah_cluster; $j++) {
                    $sum = 0;
                    for ($k = 0; $k < $jumlah_cluster; $k++) {
                        $distanceToCurrent = $this->euclideanDistance($point, $centroids[$j]);

                        $distanceToOther = $this->euclideanDistance($point, $centroids[$k]);
                        $sum += pow($distanceToCurrent / $distanceToOther, 2 / ($m - 1));
                    }
                    $membershipMatrix[$i][$j] = 1 / $sum;
                }
            }
            // 3. Hitung Fungsi Objektif
            $objectiveFunction = 0;
            foreach ($dataArray as $i => $point) {
                foreach ($centroids as $j => $centroid) {
                    $objectiveFunction += pow($membershipMatrix[$i][$j], $m) * pow($this->euclideanDistance($point, $centroid), 2);
                }
            }

            // Simpan perubahan untuk setiap iterasi
            $changes[] = [
                'iteration' => $iteration,
                'membershipMatrix' => $membershipMatrix,
                'centroids' => $centroids,
                'objectiveFunction' => $objectiveFunction,
            ];
        } while ($iteration < $max_iterasi && $this->hasConverged($membershipMatrix, $oldMembershipMatrix, $epsilon));

        // Kirim hasil ke view
        return view('algoritma.fcm_results', [
            'changes' => $changes,
            'finalCentroids' => $centroids,
            'finalObjectiveFunction' => $objectiveFunction,
        ]);
    }
    function generateMatriksAwal($jumlahCluster, $jumlahData)
    {
        $matriks = [];
        for ($i = 0; $i < $jumlahData; $i++) {
            $row = [];
            $remainingValue = 1;

            // Tentukan batas minimum untuk setiap nilai agar tidak ada yang 0
            $minValue = 0.01; // Nilai minimum per cluster
            $maxValuePerCluster = $remainingValue - ($jumlahCluster - 1) * $minValue;

            for ($j = 0; $j < $jumlahCluster - 1; $j++) {
                // Pastikan nilai random > 0 dengan batasan minValue
                $value = round(mt_rand($minValue * 100, $maxValuePerCluster * 100) / 100, 2);
                $remainingValue -= $value;
                $row[] = $value;

                // Update batas nilai maksimum untuk iterasi berikutnya
                $maxValuePerCluster = $remainingValue - ($jumlahCluster - $j - 2) * $minValue;
            }

            // Nilai terakhir untuk memenuhi total = 1
            $row[] = round($remainingValue, 2);

            // Tambahkan baris ke matriks
            $matriks[] = $row;
        }
        return $matriks;
    }




    function simpanMatriksAwal($jumlahCluster, $jumlahData)
    {
        $matriks = $this->generateMatriksAwal($jumlahCluster, $jumlahData);

        // Tentukan tabel berdasarkan jumlah cluster
        $tableName = 'matriks_' . $jumlahCluster;

        foreach ($matriks as $row) {
            $data = [];
            for ($i = 0; $i < $jumlahCluster; $i++) {
                $data['matriks_' . $jumlahCluster . '_' . ($i + 1)] = $row[$i];
            }

            DB::table($tableName)->insert($data);
        }

        return "Matriks awal untuk cluster {$jumlahCluster} berhasil disimpan!";
    }
    function generateDanSimpanSemuaMatriks($jumlahData)
    {
        // for ($jumlahCluster = 2; $jumlahCluster <= 5; $jumlahCluster++) {
        $cluster = 5;
        $this->simpanMatriksAwal($cluster, $jumlahData);
        // }
        return "Semua matriks awal berhasil digenerate dan disimpan!";
    }

    // public function genereateMatriksU()
    // {
    //     $jumlahData = Sapi::count();
    //     return $this->generateDanSimpanSemuaMatriks($jumlahData);
    // }






    public function ftahani()
    {
        return view('algoritma.ftahani');
    }
}