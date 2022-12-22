<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function patient_list()
    {
        return view('home.patient_list');
    }

    public function patient_add()
    {
        return view('home.patient_form');
    }
}
