<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreHouseController extends Controller
{
    

    public function getIndex()
    {
    	return view('remainder');
    }

    public function getImport()
    {
    	return view('import');
    }

    public function getExport()
    {
    	return view('export');
    }
}
