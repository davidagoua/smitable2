<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyseController extends Controller
{
    public function analyse_appointement_list()
    {
        return view('analyse.list', [
            'component'=>'analyse.analyse-courant',
            "title"=>'Analyses en cours'
        ]);
    }

    public function analyse_list()
    {
        return view('analyse.list', [
            'component'=>'analyse.catalogue-analyse',
            "title"=>'Analyses en cours'
        ]);
    }

    public function analyse_demandes()
    {
        return view('analyse.list', [
            'component'=>'analyse.analyse-demandes',
            'title'=>"Analyses Demandées"
        ]);
    }

    public function analyse_termines()
    {
        return view('analyse.list', [
            'component'=>'analyse.analyse-termines',
            'title'=>"Analyses terminées"
        ]);
    }
}
