<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:office');
    }

    public function getIndex()
    {
    	return view('office.remainder');
    }
}
