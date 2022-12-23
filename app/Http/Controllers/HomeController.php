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

    public function search()
    {
        return view('home.search');
    }

    public function patient_consultes()
    {
        return view('home.patient_consultes');
    }
}
