@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.service_category:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('main.service_category:list_page_header')</div>

                    <div class="panel-body">

                        <form method="post" action="/serviceCategories/save">
                        {{csrf_field()}}
                        <div class="row">

                            <div class="col-md-6">
                                <label for="sc_name">@lang('main.service_category:name_label')</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="name" id="sc_name">
                                @foreach ($errors->get('name') as $message)
                                    <?='<br/>'?>{{$message}}
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                <label for="sc_online_reservation_name">@lang('main.service_category:online_reservation_name_label')</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="online_reservation_name" id="sc_online_reservation_name">
                                @foreach ($errors->get('online_reservation_name') as $message)
                                    <?='<br/>'?>{{$message}}
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                <label for="sc_gender">@lang('main.service_category:gender_label')</label>
                            </div>
                            <div class="col-md-6">
                                <select name="gender" id="sc_gender">
                                    @foreach($genderOptions AS $gender)
                                        <option value="{{$gender['value']}}">{{$gender['label']}}</option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('gender') as $message)
                                    <?='<br/>'?>{{$message}}
                                @endforeach
                            </div>

                            <div class="col-md-12">
                                <hr/>
                                <button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
                            </div>

                        </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
