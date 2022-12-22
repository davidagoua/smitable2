@extends('base')

@section('content')
<div>
    <x-page-header :title="'Catalogue des analyses'"/>

    <livewire:analyse.catalogue-analyse />
</div>
@endsection
