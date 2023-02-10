@extends('base')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title">Patient {{ $appointement->patient->code_patient }}</h4>
                </div>
            </div>
        </div>

        <div>
            <livewire:vih-form :appointement="$appointement" :patient="$patient"/>
        </div>
    </div>
@endsection
