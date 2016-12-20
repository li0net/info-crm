@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.service_category:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if (isset($serviceCategory))
                            @lang('main.service_category:edit_form_header')
                        @else
                            @lang('main.service_category:create_form_header')
                        @endif
                    </div>

                    <div class="panel-body">

                        <form method="post" action="/serviceCategories/save">
                        {{csrf_field()}}
                        @if (isset($serviceCategory))
                            <input type="hidden" name="service_category_id" id="sc_service_category_id" value="{{$serviceCategory->service_category_id}}">
                        @endif
                        <div class="row">

                            <div class="col-md-6">
                                <label for="sc_name">@lang('main.service_category:name_label')</label>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $old = old('name');
                                if (!is_null($old)) {
                                    $value = $old;
                                } elseif (isset($serviceCategory)) {
                                    $value = $serviceCategory->name;
                                } else {
                                    $value = '';
                                }?>
                                <input type="text" name="name" id="sc_name" value="{{$value}}">
                                @foreach ($errors->get('name') as $message)
                                    <br/>{{$message}}
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                <label for="sc_online_reservation_name">@lang('main.service_category:online_reservation_name_label')</label>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $old = old('online_reservation_name');
                                if (!is_null($old)) {
                                    $value = $old;
                                } elseif (isset($serviceCategory)) {
                                    $value = $serviceCategory->online_reservation_name;
                                } else {
                                    $value = '';
                                }?>
                                <input type="text" name="online_reservation_name" id="sc_online_reservation_name" value="{{$value}}">
                                @foreach ($errors->get('online_reservation_name') as $message)
                                    <br/>{{$message}}
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                <label for="sc_gender">@lang('main.service_category:gender_label')</label>
                            </div>
                            <div class="col-md-6">
                                <select name="gender" id="sc_gender">
                                    @foreach($genderOptions AS $gender)
                                        <option
                                            @if (old('gender') AND old('gender') == $gender['value'])
                                                selected="selected"
                                            @elseif (!old('gender') AND isset($serviceCategory) AND $serviceCategory->gender == $gender['value'])
                                                selected="selected"
                                            @endif
                                        value="{{$gender['value']}}">{{$gender['label']}}
                                        </option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('gender') as $message)
                                    <br/>{{$message}}
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
