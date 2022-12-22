@extends('base')


@section('content')
<div>
    <x-page-header :title="'Ajouter un nouveau patient'"/>

    <livewire:home.add-patient/>

</div>
@endsection
