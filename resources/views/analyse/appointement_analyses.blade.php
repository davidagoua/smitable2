@extends('base')

@section('content')
<div>
    <x-page-header :title="'Liste des analyses en cours'"/>

    <livewire:analyse.analyse-courant />
</div>

@endsection
