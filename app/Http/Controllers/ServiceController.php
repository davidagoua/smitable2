<?php

namespace App\Http\Controllers;

use App\Models\Appointement;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index( Service $service)
    {
        return view('service.index', compact('service'));
    }

    public function edit(Request $request, Service $service)
    {
        return view('service.edit', compact('service'));
    }

    public function service_form(Request $request, Appointement $appointement)
    {
        $patient = $appointement->patient;
        return view('service.form', compact('appointement','patient'));
    }
}
