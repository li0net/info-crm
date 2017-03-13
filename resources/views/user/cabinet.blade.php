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
            <div class="col-lg-6">
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
                                            <img src="{{$crmuser->getAvatarUri()}}" class="img-thumbnail">
                                        </a>
                                        <input type="file" id="usercabinet_avatar" name="avatar" style="display:none;">
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <!-- inf -->
                                <p class="form-text"><b>{{$crmuser->name}}</b></p>
                                <p class="form-text"><i class="fa fa-phone"></i>&nbsp;{{$crmuser->phone}}</p>
                                <p class="form-text"><i class="fa fa-envelope"></i>&nbsp;{{$crmuser->email}}</p>
                            </div>
                        </div>
                        <div class="col-sm-12 text-right">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm">@lang('main.user:btn_my_records')</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('main.user:title_section_mailings')</h3>
                    </div>
                    <div class="box-body">
                        <div class="alert alert-success" id="mailings_form_success_alert">
                            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                            @lang('main.user:mailings_settings_saved_message')
                        </div>
                        <div class="alert alert-error" id="mailings_form_error_alert">
                            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                            @lang('main.user:mailings_settings_save_error_message')
                        </div>

                        <form id="mailings_form" method="post" action="/user/saveMailingSettings">
                            <?php
                                $checked = ($crmuser->send_news_inf_emails == '1') ? "checked" : "";
                            ?>
                            <label>
                                <input type="checkbox" name="send_news_inf_emails" id="u_send_news_inf_emails" {{$checked}} value="1">&nbsp;@lang('main.user:receive_news_emails')
                            </label>
                            <br>

                            <?php
                                $checked = ($crmuser->send_marketing_offer_emails == '1') ? "checked" : "";
                            ?>
                            <label>
                                <input type="checkbox" name="send_marketing_offer_emails" id="u_send_marketing_offer_emails" {{$checked}} value="1">&nbsp;@lang('main.user:receive_marketing_offer_emails')
                            </label>
                            <br>

                            <?php
                                $checked = ($crmuser->send_system_inf_emails == '1') ? "checked" : "";
                            ?>
                            <label>
                                <input type="checkbox" name="send_system_inf_emails" id="u_send_system_inf_emails" {{$checked}} value="1">&nbsp;@lang('main.user:receive_system_inf_emails')
                            </label>
                            <br>

                            <div class="text-right">
                                <a href="javascript:void(0)" id="mailings_submit" class="btn btn-primary btn-sm">@lang('main.btn_submit_label')</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('main.user:title_section_settings')</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-9 col-sm-offset-3">
                            <div class="alert alert-success" id="main_info_form_success_alert">
                                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                @lang('main.user:main_info_settings_saved_message')
                            </div>
                            <div class="alert alert-error" id="main_info_form_error_alert">
                                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                <span id="main_info_error_container">@lang('main.user:main_info_save_error_message')</span>
                            </div>
                        </div>
                        <form id="usercabinet_main_info_form" method="post" action="/user/saveMainInfo" class="form-horizontal">
                            <div class="form-group">
                                <label for="usr_name" class="col-sm-3 control-label">@lang('main.user:name_label')</label>
                                <div class="col-sm-9">
                                    <?php
                                    $old = old('name');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } else {
                                        $value = $crmuser->name;
                                    }?>
                                    <input type="text" name="name" id="usr_name" value="{{$value}}" class="form-control" placeholder="@lang('main.user:name_label')">
                                    @foreach ($errors->get('name') as $message)
                                    <br/>{{$message}}
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="usr_lang" class="col-sm-3 control-label text-right">@lang('main.user:lang_label_usercabinet')</label>
                                <div class="col-sm-9">
                                    <select name="lang" id="usr_lang" class="selectpicker">
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
                            <div class="form-group">
                                <label for="usr_name" class="col-sm-3 control-label text-right">@lang('main.user:name_city_usercabinet')</label>
                                <div class="col-sm-9">
                                    <?php
                                    $old = old('city');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } else {
                                        $value = $crmuser->city;
                                    }?>
                                    <input type="text" name="city" id="usr_name" value="{{$value}}" class="form-control" placeholder="@lang('main.user:name_city_usercabinet')">
                                    @foreach ($errors->get('city') as $message)
                                    <br/>{{$message}}
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="usr_info" class="col-sm-3 control-label text-right">@lang('main.user:info_label_usercabinet')</label>
                                <div class="col-sm-9">
                                    <?php
                                    $old = old('info');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } else {
                                        $value = $crmuser->info;
                                    }?>
                                    <textarea name="info" id="usr_info" class="form-control" placeholder="@lang('main.user:info_label_usercabinet')">{{$value}}</textarea>
                                    @foreach ($errors->get('info') as $message)
                                     <br/>{{$message}}
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="javascript:void(0)" id="main_info_submit" class="btn btn-primary">@lang('main.user:btn_update_main_info')</a>
                            </div>
                        </form>

                        <div class="text-left">
                            <h4 class="fat">@lang('main.user:change_password_heading')</h4>
                        </div>
                        <form id="usercabinet_password_form" method="post" action="/user/updatePassword" class="form-horizontal">

                            <div class="col-sm-9 col-sm-offset-3">
                                <div class="alert alert-success" id="password_form_success_alert">
                                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                    @lang('main.user:password_settings_saved_message')
                                </div>
                                <div class="alert alert-error" id="password_form_error_alert">
                                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                    <span id="password_error_container">@lang('main.user:main_info_save_error_message')</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr_old_password" class="col-sm-3 control-label">@lang('main.user:old_password_label_usercabinet')</label>
                                <div class="col-sm-9">
                                    <input type="password" name="old_password" id="usr_old_password" value="" class="form-control" placeholder="@lang('main.user:old_password_label_usercabinet')">
                                    @foreach ($errors->get('old_password') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="usr_new_password" class="col-sm-3 control-label">@lang('main.user:new_password_label_usercabinet')</label>
                                <div class="col-sm-9">
                                    <input type="password" name="new_password" id="usr_new_password" value="" class="form-control" placeholder="@lang('main.user:new_password_label_usercabinet')">
                                    @foreach ($errors->get('new_password') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="usr_new_password_confirmation" class="col-sm-3 control-label">@lang('main.user:new_password_confirmation_label_usercabinet')</label>
                                <div class="col-sm-9">
                                    <input type="password" name="new_password_confirmation" id="usr_new_password_confirmation" value="" class="form-control" placeholder="@lang('main.user:new_password_confirmation_label_usercabinet')">
                                    @foreach ($errors->get('new_password_confirmation') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="javascript:void(0)" id="password_submit" class="btn btn-primary btn-sm">@lang('main.user:btn_update_password')</a>
                            </div>
                        </form>

                        <div class="text-left">
                            <h4 class="fat">@lang('main.user:change_phone_heading')</h4>
                        </div>
                        <form id="usercabinet_phone_form" methos="post" action="/user/updatePhone" class="form-horizontal">
                            <div class="col-sm-9 col-sm-offset-3">
                                <div class="alert alert-success" id="phone_form_success_alert">
                                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                    @lang('main.user:phone_saved_message')
                                </div>
                                <div class="alert alert-error" id="phone_form_error_alert">
                                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                    <span id="phone_error_container">@lang('main.user:main_info_save_error_message')</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr_new_password" class="col-sm-3 control-label">@lang('main.user:current_phone_label_usercabinet')</label>
                                <div class="col-sm-9">
                                    <p>{{$crmuser->phone}}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_phone" class="col-sm-3 control-label">@lang('main.user:new_phone_label_usercabinet')</label>
                                <div class="col-sm-9">
                                    <input type="text" name="new_phone" id="usr_new_phone" value="" class="form-control" placeholder="@lang('main.user:new_phone_label_usercabinet')">
                                    <p class="help-block">@lang('main.user:help_text_phone_usercabinet')</p>
                                    @foreach ($errors->get('new_phone') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="javascript:void(0)" id="phone_submit" class="btn btn-primary btn-sm">@lang('main.user:btn_update_phone')</a>
                            </div>
                        </form>

                        <div class="form-group col-sm-12 text-left">
                            <h4 class="fat">@lang('main.user:change_email_heading')</h4>
                        </div>
                        <form id="usercabinet_email_form" methos="post" action="/user/updateEmail">

                            <div class="col-sm-9 col-sm-offset-3">
                                <div class="alert alert-success" id="email_form_success_alert">
                                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                    @lang('main.user:email_saved_message')
                                </div>
                                <div class="alert alert-error" id="email_form_error_alert">
                                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                    <span id="email_error_container">@lang('main.user:main_info_save_error_message')</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="usr_new_password" class="col-sm-3 control-label text-right">@lang('main.user:current_email_label_usercabinet')</label>
                                <div class="form-group col-sm-9">
                                    <p>{{$crmuser->email}}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="usr_new_password" class="col-sm-3 control-label text-right">@lang('main.user:new_email_label_usercabinet')</label>
                                <div class="col-sm-9">
                                    <input type="text" name="new_email" id="usr_new_email" value="" class="form-control" placeholder="@lang('main.user:new_email_label_usercabinet')">
                                    <p class="help-block">@lang('main.user:help_text_email_usercabinet')</p>
                                    @foreach ($errors->get('new_email') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="javascript:void(0)" id="email_submit" class="btn btn-primary btn-sm">@lang('main.user:btn_update_email')</a>
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