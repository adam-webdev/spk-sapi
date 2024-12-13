<?php

namespace App\Http\Controllers;

use App\Exports\SapiExport;
use App\Exports\SapiTestingExports;
use App\Imports\SapiImport;
use App\Imports\SapiTestingImports;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class Sapi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sapi = \App\Models\Sapi::all();
        return view('sapi.index', ['sapi' => $sapi]);
    }

    public function datasetSapi()
    {
        $datasetsapi = DB::table('dataset_sapis')
            ->join('sapis', 'dataset_sapis.x_sapi_id', '=', 'sapis.id')->select('sapis.jenis_sapi', 'dataset_sapis.*')
            ->get();

        return view('datasetsapi.index', ['datasetsapi' => $datasetsapi]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sapi.create');
    }
    public function formInput()
    {
        return view('sapi.import');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_sapi' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required',
            'berat' => 'required',
            'kondisi_mulut_datar' => 'required',
            'kepala' => 'required',
            'leher_bergelambir' => 'required',
            'punggung_datar' => 'required',
            'ekor_tidak_ada_legokan' => 'required',
            'kaki_tegak_besar' => 'required',
            'kondisi_gigi_lengkap' => 'required',
            'kondisi_mata_normal' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $sapi = new \App\Models\Sapi;
        $sapi->jenis_sapi = $request->jenis_sapi;
        $sapi->umur = $request->umur;
        $sapi->jenis_kelamin = $request->jenis_kelamin;
        $sapi->berat = $request->berat;
        $sapi->kondisi_mulut_datar = $request->kondisi_mulut_datar;
        $sapi->kepala = $request->kepala;
        $sapi->leher_bergelambir = $request->leher_bergelambir;
        $sapi->punggung_datar = $request->punggung_datar;
        $sapi->ekor_tidak_ada_legokan = $request->ekor_tidak_ada_legokan;
        $sapi->kaki_tegak_besar = $request->kaki_tegak_besar;
        $sapi->kondisi_gigi_lengkap = $request->kondisi_gigi_lengkap;
        $sapi->kondisi_mata_normal = $request->kondisi_mata_normal;
        $sapi->save();
        session()->flash('success', 'Data berhasil disimpan.');

        return redirect('/sapi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sapi = \App\Models\Sapi::find($id);
        if (!$sapi) {
            return redirect('/sapi');
        }
        return view('sapi.show', ['sapi' => $sapi]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sapi = \App\Models\Sapi::find($id);
        return view('sapi.edit', ['sapi' => $sapi]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_sapi' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required',
            'berat' => 'required',
            'kondisi_mulut_datar' => 'required',
            'kepala' => 'required',
            'leher_bergelambir' => 'required',
            'punggung_datar' => 'required',
            'ekor_tidak_ada_legokan' => 'required',
            'kaki_tegak_besar' => 'required',
            'kondisi_gigi_lengkap' => 'required',
            'kondisi_mata_normal' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sapi = \App\Models\Sapi::find($id);
        if (!$sapi) {
            return redirect('/sapi');
        }
        $sapi->jenis_sapi = $request->jenis_sapi;
        $sapi->umur = $request->umur;
        $sapi->jenis_kelamin = $request->jenis_kelamin;
        $sapi->berat = $request->berat;
        $sapi->kondisi_mulut_datar = $request->kondisi_mulut_datar;
        $sapi->kepala = $request->kepala;
        $sapi->leher_bergelambir = $request->leher_bergelambir;
        $sapi->punggung_datar = $request->punggung_datar;
        $sapi->ekor_tidak_ada_legokan = $request->ekor_tidak_ada_legokan;
        $sapi->kaki_tegak_besar = $request->kaki_tegak_besar;
        $sapi->kondisi_gigi_lengkap = $request->kondisi_gigi_lengkap;
        $sapi->kondisi_mata_normal = $request->kondisi_mata_normal;
        $sapi->save();
        session()->flash('success', 'Data berhasil diubah.');

        return redirect('/sapi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sapi = \App\Models\Sapi::find($id);
        if (!$sapi) {

            session()->flash('error', 'Data tidak ditemukan.');

            return redirect('/sapi');
        }
        $sapi->delete();
        session()->flash('success', 'Data berhasil dihapus.');

        return redirect('/sapi');
    }


    public function ImportData(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'file_import' => 'required|mimes:xlsx,csv,xls'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            DB::table('sapis')->truncate();

            Excel::import(new SapiImport, $request->file('file_import'));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal', 'Data gagal dimasukan');
            return redirect()->route('sapi.index');
        }
        Excel::import(new SapiImport, $request->file('file_import'));


        Alert::success('Berhasil', 'Data berhasil dimasukan');
        return redirect()->route('sapi.index');
    }

    public function ExportExcel()
    {
        return Excel::download(new SapiExport, 'sapi.xlsx');
    }

    public function ExportCSV()
    {
        return Excel::download(new SapiExport, 'sapi.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }


    // normalisasi data sapi
    public function normalisasiDataSapi()
    {
        $data = \App\Models\Sapi::all()
            ->whereNotNull('jenis_sapi')
            ->whereNotNull('umur')
            ->whereNotNull('jenis_kelamin')
            ->whereNotNull('berat')
            ->whereNotNull('kondisi_mulut_datar')
            ->whereNotNull('kepala')
            ->whereNotNull('leher_bergelambir')
            ->whereNotNull('punggung_datar')
            ->whereNotNull('ekor_tidak_ada_legokan')
            ->whereNotNull('kaki_tegak_besar')
            ->whereNotNull('kondisi_gigi_lengkap')
            ->whereNotNull('kondisi_mata_normal');
        // ->where('jenis_sapi', '!=', '-')
        // ->where('berat', '!=', '0')
        // ->where('umur', '!=', '0')
        // ->where('umur', '<=', '2500000');


        $datasetSapi = [];
        foreach ($data as $key => $value) {
            $rowDataset = [
                'x_sapi_id' => $value->id,
                'x1' => 0,
                'x2' => 0,
                'x3' => 0,
                'x4' => 0,
                'x5' => 0,
                'x6' => 0,
                'x7' => 0,
                'x8' => 0,
                'x9' => 0,
                'x10' => 0,
                'x11' => 0,
            ];

            //x1 umur
            if ($value->umur > 50) {
                $rowDataset['x1'] = 4;
            } elseif ($value->umur > 35 && $value->umur <= 50) {
                $rowDataset['x1'] = 3;
            } elseif ($value->umur > 24 && $value->umur <= 35) {
                $rowDataset['x1'] = 2;
            } elseif ($value->umur < 24) {
                $rowDataset['x1'] = 1;
            }

            //x2 jenis kelamin
            if (str_contains(strtolower($value->jenis_kelamin), 'jantan')) {
                $rowDataset['x2'] = 2;
            } else {
                $rowDataset['x2'] = 1;
            }

            //x3 berat
            if ($value->berat > 450) {
                $rowDataset['x3'] = 4;
            } elseif ($value->berat > 300 && $value->berat <= 450) {
                $rowDataset['x3'] = 3;
            } elseif ($value->berat > 150 && $value->berat <= 300) {
                $rowDataset['x3'] = 2;
            } elseif ($value->berat < 150) {
                $rowDataset['x3'] = 1;
            }

            //x4 kondisi_mulut_datar
            if (str_contains(strtolower($value->kondisi_mulut_datar), 'datar')) {
                $rowDataset['x4'] = 2;
            } else {
                $rowDataset['x4'] = 1;
            }

            //x5 ukuran kepala sesuai dengan berat
            if (str_contains(strtolower($value->kepala), 'ya')) {
                $rowDataset['x5'] = 2;
            } else {
                $rowDataset['x5'] = 1;
            }

            //x6 leher bergelambir
            if (str_contains(strtolower($value->leher_bergelambir), 'ya')) {
                $rowDataset['x6'] = 2;
            } else {
                $rowDataset['x6'] = 1;
            }

            //x7 punggung datar
            if (str_contains(strtolower($value->punggung_datar), 'datar')) {
                $rowDataset['x7'] = 2;
            } else {
                $rowDataset['x7'] = 1;
            }

            //x8 Ekor tidak ada legokan
            if (str_contains(strtolower($value->ekor_tidak_ada_legokan), 'ya')) {
                $rowDataset['x8'] = 2;
            } else {
                $rowDataset['x8'] = 1;
            }

            //x9 Kaki tegak besar
            if (str_contains(strtolower($value->kaki_tegak_besar), 'ya')) {
                $rowDataset['x9'] = 2;
            } else {
                $rowDataset['x9'] = 1;
            }

            //x10 kondisi gigi lengkap
            if (str_contains(strtolower($value->kondisi_gigi_lengkap), 'ya')) {
                $rowDataset['x10'] = 2;
            } else {
                $rowDataset['x10'] = 1;
            }

            //x11 kondisi mata normal / menurun
            if (str_contains(strtolower($value->kondisi_mata_normal), 'normal')) {
                $rowDataset['x11'] = 2;
            } else {
                $rowDataset['x11'] = 1;
            }

            $rowDataset['created_at'] = Carbon::now();
            $rowDataset['updated_at'] = Carbon::now();
            array_push($datasetSapi, $rowDataset);
        }


        DB::table('dataset_sapis')->truncate();
        DB::table('dataset_sapis')->insert($datasetSapi);

        session()->flash('success', 'Data berhasil diload.');
        return redirect('dataset-sapi');
    }
}
