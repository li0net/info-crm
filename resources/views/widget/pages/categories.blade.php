@extends('widget.layouts.main')
@section('content')
    <h1>Выберите категорию услуги</h1>
    @foreach ($categories as $category)
        <a class="row category-row" data-id="{{ $category->service_category_id }}" href="#">
            <div class="col-sm-4">
                {{$category->online_reservation_name}}
            </div>
            <div class="col-sm-8">{{$category->gender}}</div>
        </a>
        <hr>
    @endforeach
@stop
