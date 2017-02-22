@extends('widget.layouts.main')
@section('content')
    <h1>Выберите филиал</h1>
    @foreach ($organizations as $organization)
        <div> {{ $organization->organization_id }} </div>
        <div> {{ $organization->name }} </div>
        <div> {{ $organization->category }} </div>
        <div> {{ $organization->shortinfo }} </div>
        <div> <img src="{{$organization->getLogoUri()}}"> </div>
        <hr>
    @endforeach
@stop