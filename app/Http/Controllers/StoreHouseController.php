<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreHouseController extends Controller
{
    

    public function getIndex()
    {
    	return view('storehouse.remainder');
    }

    public function getImport()
    {
    	return view('storehouse.import');
    }

    public function getExport()
    {
    	return view('storehouse.export');
    }
}
