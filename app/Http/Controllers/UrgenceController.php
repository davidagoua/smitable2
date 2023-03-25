<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrgenceController extends Controller
{
    public function form()
    {
        return view('urgence.form');
    }

    public function liste()
    {
        return view('urgence.liste');
    }
}
