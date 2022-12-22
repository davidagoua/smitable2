<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyseController extends Controller
{
    public function analyse_appointement_list()
    {
        return view('analyse.appointement_analyses');
    }

    public function analyse_list()
    {
        return view('analyse.list');
    }
}
