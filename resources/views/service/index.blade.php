@extends('base')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title">Service {{ $service->nom }}</h4>
                </div>
            </div>
        </div>

        <div>
            <livewire:service.list-patient :service="$service"/>
        </div>
    </div>
@endsection
