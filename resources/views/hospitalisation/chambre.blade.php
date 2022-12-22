@extends('base')

@section('content')
<div>
    <x-page-header :title="'Chambres d\'hospitalisation'" />
    <livewire:hospitalisation.chambre-list/>
</div>
@endsection
