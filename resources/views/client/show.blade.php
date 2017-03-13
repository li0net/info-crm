@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client:form_page_header')
@endsection


@section('main-content')
<section class="content-header">
    <h1>{{$client->name}}</h1>
    <!--<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Advanced Elements</li>
    </ol>-->
</section>
@if (isset($client))
<input type="hidden" name="client_id" id="c_client_id" value="{{$client->client_id}}">
@endif
<div class="row">
    <div class="col-md-6">
        <span>@lang('main.client:name_label')</span>
    </div>
    <div class="col-md-6">
        <span>{{$client->name}}</span>
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:phone_label')</span>
    </div>
    <div class="col-md-6">
        @if ($crmuser->hasAccessTo('client_phone', 'view', 0))
        <span>{{$client->phone}}</span>
        @else
        <span>@lang('main.user:grid_phone_hidden_message')</span>
        @endif
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:email_label')</span>
    </div>
    <div class="col-md-6">
        @if(trim($client->email) != '')
        <span><a href="mailto:{{$client->email}}">{{$client->email}}</a></span>
        @else
        <span>{{$client->email}}</span>
        @endif
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:client_category_label')</span>
    </div>
    <div class="col-md-6">
        <?php
        $hasCategories = FALSE;
        foreach($clientCategoriesOptions AS $clientCategory) {
            foreach($client->categories()->get() AS $cat) {
                if($cat->cc_id == $clientCategory['value']) {
                    $hasCategories = TRUE;
                    $value = $clientCategory['label'];
                    $style = "style=\"background-color:{$clientCategory['color']}\"";

                    echo "<span $style>".htmlentities($value)."</span>&nbsp;";
                }
            }
        }
        if (!$hasCategories) {
            echo "<span>&nbsp;</span>";
        }
        ?>
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:gender_label')</span>
    </div>
    <div class="col-md-6">
        <?php
        $value="";
        foreach($genderOptions AS $gender) {
            if (($client->gender == $gender['value']) OR (trim($client->gender) == '' AND $gender['value'] == 'null')) {
                $value = $gender['label'];
            }
        }
        ?>
        <span>{{$value}}</span>
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:importance_label')</span>
    </div>
    <div class="col-md-6">
        <?php
        $value="";
        foreach($importanceOptions AS $importance) {
            if (($client->importance == $importance['value']) OR (trim($client->importance) == '' AND $importance['value'] == 'null')) {
                $value = $importance['label'];
            }
        }
        ?>
        <span style="width: 100%">{{$value}}</span>
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:discount_label')</span>
    </div>
    <div class="col-md-6">
        <span>{{$client->discount}}%</span>
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:birthday_label')</span>
    </div>
    <div class="col-md-6">
        <span>{{date('Y-m-d', strtotime($client->birthday))}}</span>
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:comment_label')</span>
    </div>
    <div class="col-md-6">
        <span>{{$client->comment}}</span>
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:sms_label')</span>
    </div>
    <div class="col-md-6">
        <?php
        if ($client->birthday_sms == '1') { $checked = "checked"; } else { $checked = "";}
        ?>
        <input type="checkbox" disabled="disabled" name="birthday_sms" id="c_birthday_sms" {{$checked}} value="1">&nbsp;@lang('main.client:birthday_sms_label')
        <br>

        <?php
        if ($client->do_not_send_sms == '1') { $checked = "checked"; } else { $checked = ""; }
        ?>
        <input type="checkbox" disabled="disabled" name="do_not_send_sms" id="c_do_not_send_sms" {{$checked}} value="1">&nbsp;@lang('main.client:do_not_send_sms_label')
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:online_record_label')</span>
    </div>
    <div class="col-md-6">
        <?php
        if ($client->online_reservation_available == '0') { $checked = "checked"; } else { $checked = ""; }
        ?>
        <input type="checkbox" disabled="disabled" name="online_reservation_available" id="c_online_reservation_available" {{$checked}} value="1">&nbsp;@lang('main.client:online_reservation_available')
    </div>

    <div class="col-md-6">
        <span>@lang('main.client:total_bought_label')</span>
    </div>
    <div class="col-md-6">
        <span>{{round($client->total_bought, 2)}}</span>
    </div>
    <div class="col-md-6">
        <span>@lang('main.client:total_paid_label')</span>
    </div>
    <div class="col-md-6">
        <span>{{round($client->total_paid, 2)}}</span>
    </div>
</div>
<div class="row m-t">
    <div class="col-md-12">
        <button class="btn btn-info " onclick="window.location='{{action('ClientsController@index')}}'">@lang('main.clients:btn_show_grid_label')</button>
        <button class="btn btn-primary pull-right" onclick="window.location='{{action('ClientsController@edit', [$client->client_id])}}'">@lang('main.clients:btn_edit_label')</button>
    </div>
</div>
@endsection
