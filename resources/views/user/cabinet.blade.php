@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.user:page_title_cabinet')
@endsection


@section('main-content')

    <section class="content-header">
        <h1>@lang('main.user:title_personal_data_settings')</h1>
        <!--<ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Advanced Elements</li>
        </ol>-->
    </section>

    <section class="content">
        <div class="row">

            <div class="col-lg-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('main.user:title_section_personal_data')</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- avatar -->
                                <div class="text-center">
                                    <form id="avatar_form" method="post" action="/user/saveAvatar" style="height:120px;">
                                        <!--<img src="/img/crm/avatar/avatar100.jpg">-->
                                        <a id="avatar_anchor" href="#">
                                            <img src="{{$crmuser->getAvatarUri()}}">
                                        </a>
                                        <input type="file" id="usercabinet_avatar" name="avatar" style="display:none;">
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <!-- inf -->
                                <h3>{{$crmuser->name}}</h3>
                                <p><i class="fa fa-phone"></i>&nbsp;{{$crmuser->phone}}</p>
                                <p><i class="fa fa-envelope"></i>&nbsp;{{$crmuser->email}}</p>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <a href="#" class="btn btn-primary btn-sm">@lang('main.user:btn_my_records')</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('main.user:title_section_mailings')</h3>
                    </div>
                    <div class="box-body">
                        <div class="alert alert-success" id="mailings_form_success_alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            @lang('main.user:mailings_settings_saved_message')
                        </div>
                        <div class="alert alert-error" id="mailings_form_error_alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            @lang('main.user:mailings_settings_save_error_message')
                        </div>

                        <form id="mailings_form" method="post" action="/user/saveMailingSettings">
                            <?php
                            if ($crmuser->send_news_inf_emails == '1') {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }?>
                            <label>
                                <input type="checkbox" name="send_news_inf_emails" id="u_send_news_inf_emails" {{$checked}} value="1">&nbsp;@lang('main.user:receive_news_emails')
                            </label>
                            <br>

                            <?php
                            if ($crmuser->send_marketing_offer_emails == '1') {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }?>
                            <label>
                                <input type="checkbox" name="send_marketing_offer_emails" id="u_send_marketing_offer_emails" {{$checked}} value="1">&nbsp;@lang('main.user:receive_marketing_offer_emails')
                            </label>
                            <br>

                            <?php
                            if ($crmuser->send_system_inf_emails == '1') {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }?>
                            <label>
                                <input type="checkbox" name="send_system_inf_emails" id="u_send_system_inf_emails" {{$checked}} value="1">&nbsp;@lang('main.user:receive_system_inf_emails')
                            </label>
                            <br>

                            <p><a href="#" id="mailings_submit" class="btn btn-primary btn-sm">@lang('main.btn_submit_label')</a></p>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-lg-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('main.user:title_section_settings')</h3>
                    </div>
                    <div class="box-body">
                        <div class="alert alert-success" id="main_info_form_success_alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            @lang('main.user:main_info_settings_saved_message')
                        </div>
                        <div class="alert alert-error" id="main_info_form_error_alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <span id="main_info_error_container">@lang('main.user:main_info_save_error_message')</span>
                        </div>

                        <form id="usercabinet_main_info_form" methos="post" action="/user/saveMainInfo">
                        <div class="row">
                            <div class="form-group col-sm-3 text-right">
                                <label>@lang('main.user:name_label')</label>
                            </div>
                            <div class="form-group col-sm-9">
                                <?php
                                $old = old('name');
                                if (!is_null($old)) {
                                    $value = $old;
                                } else {
                                    $value = $crmuser->name;
                                }?>
                                <input type="text" name="name" id="usr_name" value="{{$value}}" class="form-control">
                                @foreach ($errors->get('name') as $message)
                                    <br/>{{$message}}
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-3 text-right">
                                <label>@lang('main.user:lang_label_usercabinet')</label>
                            </div>
                            <div class="form-group col-sm-9">
                                <select name="lang" id="usr_lang" class="form-control">
                                    @foreach($langOptions AS $lang)
                                        <option
                                            @if (old('lang') AND old('lang') == $lang['value'])
                                            selected="selected"
                                            @elseif (!old('lang') AND $crmuser->lang == $lang['value'])
                                            selected="selected"
                                            @elseif (!old('lang') AND !$crmuser->lang AND isset($lang['selected']) AND $lang['selected'] == true)
                                            selected="selected"
                                            @endif
                                        value="{{$lang['value']}}">{{$lang['label']}}</option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('lang') as $message)
                                    <br/>{{$message}}
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-3 text-right">
                                <label>@lang('main.user:name_city_usercabinet')</label>
                            </div>
                            <div class="form-group col-sm-9">
                                <?php
                                $old = old('city');
                                if (!is_null($old)) {
                                    $value = $old;
                                } else {
                                    $value = $crmuser->city;
                                }?>
                                <input type="text" name="city" id="usr_name" value="{{$value}}" class="form-control">
                                @foreach ($errors->get('city') as $message)
                                    <br/>{{$message}}
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-3 text-right">
                                <label>@lang('main.user:info_label_usercabinet')</label>
                            </div>
                            <div class="form-group col-sm-9">
                                <?php
                                $old = old('info');
                                if (!is_null($old)) {
                                    $value = $old;
                                } else {
                                    $value = $crmuser->info;
                                }?>
                                <textarea name="info" id="usr_info" class="form-control">{{$value}}</textarea>
                                @foreach ($errors->get('info') as $message)
                                    <br/>{{$message}}
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-3 text-right">
                            </div>
                            <div class="form-group col-sm-9">
                                <p><a href="#" id="main_info_submit" class="btn btn-primary btn-sm">@lang('main.user:btn_update_main_info')</a></p>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection

<!-- Push a script dynamically from a view -->
@push('scripts')
    <script src="{{asset('js/usercabinet.js')}}"></script>
@endpush