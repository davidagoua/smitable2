@extends('base')

@section('content')
    <x-page-header :title="'Liste des Rendez-vous'"/>
    <div>
        <livewire:home.list-patient/>
    </div>

@endsection
