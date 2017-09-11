<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function getIndex()
    {
    	return view('office.remainder');
    }
}
