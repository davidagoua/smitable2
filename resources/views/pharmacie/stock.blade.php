@extends('base')

@section('content')
<div>
    <x-page-header :title="$title"/>

    @if($component == 'pharmacie.stock')
    <livewire:pharmacie.stock />
    @elseif($component == 'pharmacie.vente')
    <livewire:pharmacie.vente />

    @endif
</div>

@endsection
