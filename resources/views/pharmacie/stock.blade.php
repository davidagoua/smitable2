@extends('base')

@section('content')
<div>
    <x-page-header :title="'Stock de medicaments'"/>

    <livewire:pharmacie.stock />
</div>

@endsection
