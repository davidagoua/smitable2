<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAppointementRequest;
use App\Models\Appointement;
use App\Models\Patient;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    public function create_appointements(CreateAppointementRequest $request)
    {

        $data = $request->validated();

        // create_patient
        $patient = Patient::create($data);

        // create appointement
        $appointements = new Appointement($data);
        $appointements->patient_id = $patient->id;
        $appointements->save();
        $appointements->setStatus('routine_1');

        return response()->json([
            'success'=>True,
            'data'=> $appointements
        ]);
    }

    public function liste_appointements(Request $request)
    {
        $query = Appointement::currentStatus('routine_1');

        return response()->json($query->get());
    }
}
