@extends('base')

@section('content')
<div>
    <x-page-header :title="$title"/>


    @if($component == 'analyse.catalogue-analyse')
    <livewire:analyse.catalogue-analyse />
    @elseif($component == 'analyse.analyse-courant')
    <livewire:analyse.analyse-courant />
    @elseif($component == 'analyse.analyse-demandes')
    <livewire:analyse.analyse-demandes />
    @elseif($component == 'analyse.analyse-termines')
    <livewire:analyse.analyse-termines />
    @endif
</div>
@endsection
