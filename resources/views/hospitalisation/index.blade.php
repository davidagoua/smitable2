@extends('base')

@section('content')
    <div>
        <x-page-header :title="'Patients hospitalisés'" />
        <livewire:hospitalisation.reservation/>
    </div>
@endsection
