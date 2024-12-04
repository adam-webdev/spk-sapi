<?php

namespace App\Http\Controllers;

use App\Models\Sapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatrixController extends Controller
{


    // function generateMatriksAwal($jumlahCluster, $jumlahData)
    // {
    //     $matriks = [];
    //     for ($i = 0; $i < $jumlahData; $i++) {
    //         $row = [];
    //         $remainingValue = 1;

    //         // Tentukan batas minimum untuk setiap nilai agar tidak ada yang 0
    //         $minValue = 0.01; // Nilai minimum per cluster
    //         $maxValuePerCluster = $remainingValue - ($jumlahCluster - 1) * $minValue;

    //         for ($j = 0; $j < $jumlahCluster - 1; $j++) {
    //             // Pastikan nilai random > 0 dengan batasan minValue
    //             $value = round(mt_rand($minValue * 100, $maxValuePerCluster * 100) / 100, 2);
    //             $remainingValue -= $value;
    //             $row[] = $value;

    //             // Update batas nilai maksimum untuk iterasi berikutnya
    //             $maxValuePerCluster = $remainingValue - ($jumlahCluster - $j - 2) * $minValue;
    //         }

    //         // Nilai terakhir untuk memenuhi total = 1
    //         $row[] = round($remainingValue, 2);

    //         // Tambahkan baris ke matriks
    //         $matriks[] = $row;
    //     }
    //     dd($matriks);
    //     return $matriks;
    // }

    function generateMatriksAwal($jumlahCluster, $jumlahData)
    {
        $matriks = [];
        for ($i = 0; $i < $jumlahData; $i++) {
            $row = [];
            $remainingValue = 1;

            // Tentukan batas minimum untuk setiap nilai agar tidak ada yang 0
            $minValue = 0.01; // Nilai minimum per cluster

            for ($j = 0; $j < $jumlahCluster - 1; $j++) {
                // Hitung batas maksimum untuk cluster ini
                $maxValuePerCluster = $remainingValue - ($jumlahCluster - $j - 1) * $minValue;

                // Pastikan maxValuePerCluster minimal sama dengan minValue
                $maxValuePerCluster = max($maxValuePerCluster, $minValue);

                // Generate nilai random
                $value = round(mt_rand($minValue * 100, $maxValuePerCluster * 100) / 100, 2);

                $remainingValue -= $value; // Kurangi remainingValue
                $row[] = $value;
            }

            // Nilai terakhir untuk memenuhi total = 1
            $row[] = round($remainingValue, 2);

            // Tambahkan baris ke matriks
            $matriks[] = $row;
        }

        // Debug matriks (hapus 'dd()' jika tidak perlu)

        return $matriks;
    }



    function simpanMatriksAwal($jumlahCluster, $jumlahData)
    {
        $matriks = $this->generateMatriksAwal($jumlahCluster, $jumlahData);

        // Tentukan tabel berdasarkan jumlah cluster
        $tableName = 'matriks_' . $jumlahCluster;
        DB::table($tableName)->truncate();
        foreach ($matriks as $row) {
            $data = [];
            for ($i = 0; $i < $jumlahCluster; $i++) {
                $data['matriks_' . $jumlahCluster . '_' . ($i + 1)] = $row[$i];
            }
            // Tambahkan timestamps
            $data['created_at'] = now();
            $data['updated_at'] = now();

            DB::table($tableName)->insert($data);
        }

        return "Matriks awal untuk cluster {$jumlahCluster} berhasil disimpan!";
    }
    function generateDanSimpanSemuaMatriks($cluster, $jumlahData)
    {
        // for ($jumlahCluster = 2; $jumlahCluster <= 5; $jumlahCluster++) {
        $this->simpanMatriksAwal($cluster, $jumlahData);
        // }
    }

    // public function genereateMatriksU(Request $request)
    // {
    //     $jumlahData = Sapi::count();
    //     $cluster = $request->cluster;
    //     session()->flash('success', 'Matrix berhasil digenerate.');
    //     return $this->generateDanSimpanSemuaMatriks($cluster, $jumlahData);
    // }

    public function getMatrix2x2()
    {
        $matrix2 = DB::table('matriks_2')->get();
        return view('matrix.matrix2x2', compact('matrix2'));
    }
    public function generateMatrix2()
    {
        $jumlahData = Sapi::count();
        $cluster = 2;
        $this->generateDanSimpanSemuaMatriks($cluster, $jumlahData);
        session()->flash('success', 'Matrix berhasil digenerate.');

        return redirect()->route('datamatrix.2x2');
    }

    public function getMatrix3x3()
    {
        $matrix3 = DB::table('matriks_3')->get();
        return view('matrix.matrix3x3', compact('matrix3'));
    }
    public function generateMatrix3()
    {
        $jumlahData = Sapi::count();
        $cluster = 3;
        $this->generateDanSimpanSemuaMatriks($cluster, $jumlahData);
        session()->flash('success', 'Matrix berhasil digenerate.');

        return redirect()->route('datamatrix.3x3');
    }
    public function getMatrix4x4()
    {
        $matrix4 = DB::table('matriks_4')->get();
        return view('matrix.matrix4x4', compact('matrix4'));
    }
    public function generateMatrix4()
    {
        $jumlahData = Sapi::count();
        $cluster = 4;
        $this->generateDanSimpanSemuaMatriks($cluster, $jumlahData);
        session()->flash('success', 'Matrix berhasil digenerate.');

        return redirect()->route('datamatrix.4x4');
    }
    public function getMatrix5x5()
    {
        $matrix5 = DB::table('matriks_5')->get();
        return view('matrix.matrix5x5', compact('matrix5'));
    }
    public function generateMatrix5()
    {
        $jumlahData = Sapi::count();
        $cluster = 5;
        $this->generateDanSimpanSemuaMatriks($cluster, $jumlahData);
        session()->flash('success', 'Matrix berhasil digenerate.');

        return redirect()->route('datamatrix.5x5');
    }
}
