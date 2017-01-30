@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client:form_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if (isset($client))
                            @lang('main.client:edit_form_header')
                        @else
                            @lang('main.client:create_form_header')
                        @endif
                    </div>

                    <div class="panel-body">

                        <form method="post" action="/clients/save">
                            {{csrf_field()}}
                            @if (isset($client))
                                <input type="hidden" name="client_id" id="c_client_id" value="{{$client->client_id}}">
                            @endif
                            <div class="row">

                                <!--
                                Имя (name)
                                Сотовый (phone)
                                Email (email)
                                Категория (dropdown - category_id)
                                Пол (gender)
                                Класс важности (селект - без категории, золото, серебро, бронза) importance enum('bronze','silver','gold')
                                Скидка  discount tinyint(3)
                                --Номер карты--
                                Дата рождения  birthday
                                Комментарий (textarea - comment)
                                SMS
                                    v Поздравлять с днем рождения по SMS  birthday_sms
                                    v Исключить из SMS рассылок  do_not_send_sms
                                Онлайн запись
                                    v Запретить записываться онлайн  online_reservation_available

                                Продано  total_bought
                                Оплачено  total_paid
                                -->

                                <div class="col-md-6">
                                    <label for="c_name">@lang('main.client:name_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('name');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($client)) {
                                        $value = $client->name;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="name" id="c_name" value="{{$value}}">
                                    @foreach ($errors->get('name') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="c_phone">@lang('main.client:phone_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('phone');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($client)) {
                                        $value = $client->phone;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="phone" id="c_phone" value="{{$value}}">
                                    @foreach ($errors->get('phone') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="c_email">@lang('main.client:email_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('email');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($client)) {
                                        $value = $client->email;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="email" id="c_email" value="{{$value}}">
                                    @foreach ($errors->get('email') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="c_category_id">@lang('main.client:client_category_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <!--<select name="category_id" id="c_category_id" class="js-select-basic-multiple" multiple="multiple">-->
                                    <select name="category_id" id="c_category_id" class="js-select-basic-single" style="width: 160px">
                                        @foreach($clientCategoriesOptions AS $clientCategory)
                                            <option data-color="{{$clientCategory['color']}}"
                                                @if (old('category_id') AND old('service_category_id') == $clientCategory['value'])
                                                selected="selected"
                                                @elseif (!old('category_id') AND isset($client) AND $client->category_id == $clientCategory['value'])
                                                selected="selected"
                                                @elseif (isset($clientCategory['selected']) AND $clientCategory['selected'] == true)
                                                selected="selected"
                                                @endif
                                                value="{{$clientCategory['value']}}">{{$clientCategory['label']}}</option>
                                        @endforeach
                                    </select>
                                    @foreach ($errors->get('category_id') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="c_gender">@lang('main.client:gender_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="gender" id="c_gender">
                                        @foreach($genderOptions AS $gender)
                                            <option
                                                    @if (old('gender') AND old('gender') == $gender['value'])
                                                    selected="selected"
                                                    @elseif (!old('gender') AND isset($client) AND $client->gender == $gender['value'])
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

                                <div class="col-md-6">
                                    <label for="c_importance">@lang('main.client:importance_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="importance" id="c_importance">
                                        @foreach($importanceOptions AS $importance)
                                            <option
                                                    @if (old('importance') AND old('importance') == $importance['value'])
                                                    selected="selected"
                                                    @elseif (!old('importance') AND isset($client) AND $client->importance == $importance['value'])
                                                    selected="selected"
                                                    @endif
                                                    value="{{$importance['value']}}">{{$importance['label']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @foreach ($errors->get('importance') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="c_discount">@lang('main.client:discount_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('discount');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($client)) {
                                        $value = $client->discount;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="discount" id="c_discount" value="{{$value}}">
                                    @foreach ($errors->get('discount') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <!-- Дата рождения  birthday -->
                                <div class="col-md-6">
                                    <label for="c_birthday">@lang('main.client:birthday_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('birthday');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($client)) {
                                        $value = date('Y-m-d', strtotime($client->birthday));
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="birthday" id="c_birthday" value="{{$value}}">
                                    @foreach ($errors->get('birthday') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <!-- Комментарий (textarea - comment) -->
                                <div class="col-md-6">
                                    <label for="c_comment">@lang('main.client:comment_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('comment');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($client)) {
                                        $value = $client->comment;
                                    } else {
                                        $value = '';
                                    }?>
                                    <textarea name="comment" id="c_comment">{{$value}}</textarea>
                                    @foreach ($errors->get('comment') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label>@lang('main.client:sms_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('birthday_sms');
                                    if (!is_null($old)) {
                                        if ($old == '1') { $checked = "checked"; } else { $checked = ""; }
                                    } elseif (isset($client)) {
                                        if ($client->birthday_sms == '1') { $checked = "checked"; } else { $checked = ""; }
                                    } else {
                                        $checked = "";
                                    }?>
                                    <input type="checkbox" name="birthday_sms" id="c_birthday_sms" {{$checked}} value="1">&nbsp;@lang('main.client:birthday_sms_label')
                                    <br>

                                    <?php
                                    $old = old('do_not_send_sms');
                                    if (!is_null($old)) {
                                        if ($old == '1') { $checked = "checked"; } else { $checked = ""; }
                                    } elseif (isset($client)) {
                                        if ($client->do_not_send_sms == '1') { $checked = "checked"; } else { $checked = ""; }
                                    } else {
                                        $checked = "";
                                    }?>
                                    <input type="checkbox" name="do_not_send_sms" id="c_do_not_send_sms" {{$checked}} value="1">&nbsp;@lang('main.client:do_not_send_sms_label')
                                </div>

                                <div class="col-md-6">
                                    <label>@lang('main.client:online_record_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('online_reservation_available');
                                    if (!is_null($old)) {
                                        if ($old == '0') { $checked = "checked"; } else { $checked = ""; }
                                    } elseif (isset($client)) {
                                        if ($client->online_reservation_available == '0') { $checked = "checked"; } else { $checked = ""; }
                                    } else {
                                        $checked = "";
                                    }?>
                                    <input type="checkbox" name="online_reservation_available" id="c_online_reservation_available" {{$checked}} value="1">&nbsp;@lang('main.client:online_reservation_available')
                                </div>

                                <div class="col-md-6">
                                    <label for="c_total_bought">@lang('main.client:total_bought_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('total_bought');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($client)) {
                                        $value = $client->total_bought;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="total_bought" id="c_total_bought" value="{{$value}}">
                                    @foreach ($errors->get('total_bought') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="c_total_paid">@lang('main.client:total_paid_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('total_paid');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($client)) {
                                        $value = $client->total_paid;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="total_paid" id="c_total_paid" value="{{$value}}">
                                    @foreach ($errors->get('total_paid') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-12">
                                    <hr/>
                                    <button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
                                </div>


                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
