<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PharmacieController extends Controller
{
    public function list_ordonance()
    {
        return view('pharmacie.list_ordonance');
    }

    public function stock()
    {
        return view('pharmacie.stock');
    }
}
