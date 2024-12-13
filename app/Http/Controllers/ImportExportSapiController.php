<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportExportSapiController extends Controller
{
    //

    public function importForm()
    {
        return view('sapi.import');
    }
}
