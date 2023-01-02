<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PharmacieController extends Controller
{
    public function list_ordonance()
    {
        return view('pharmacie.stock', [
            'component'=>'pharmacie.ordonance',
            'title'=>'Liste des ordonances'
        ]);
    }

    public function stock()
    {
        return view('pharmacie.stock', [
            'component'=>'pharmacie.stock',
            'title'=>'Stock'
        ]);
    }
}
