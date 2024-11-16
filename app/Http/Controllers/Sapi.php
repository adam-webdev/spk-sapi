<?php

namespace App\Http\Controllers;

use App\Exports\SapiExport;
use App\Imports\SapiImport;
use Illuminate\Http\Request;
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
        return redirect('/sapi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sapi = \App\Models\Sapi::find($id);
        if (!$sapi) {
            return redirect('/sapi');
        }
        $sapi->delete();
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
}
