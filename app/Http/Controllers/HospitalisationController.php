<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HospitalisationController extends Controller
{
    public function index()
    {
        return view('hospitalisation.index');
    }

    public function chambre()
    {
        return view('hospitalisation.chambre');
    }
}
