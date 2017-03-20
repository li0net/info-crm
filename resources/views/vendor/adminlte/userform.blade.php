@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @if (isset($crmuser))
        @lang('main.user:edit_form_header')
    @else
        @lang('main.user:create_form_header')
    @endif
@endsection


@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.users') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li><a href="{{ url('/users')}}">{{ trans('adminlte_lang::message.users') }}</a></li>
        <li class="active">
            @if (isset($crmuser))
            @lang('main.user:edit_form_header')
            @else
            @lang('main.user:create_form_header')
            @endif
        </li>
    </ol>
</section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="user_tabs_header" role="tablist">
                    <li class="active"><a href="#tab_user_properties" role="tab" data-toggle="tab"><i class="fa address-book-o" aria-hidden="true"></i>&nbsp;@lang('main.user:properties_tab_label')</a></li>
                    @if(isset($crmuser))
                    <li><a href="#tab_user_permissions" role="tab" data-toggle="pill"><i class="fa gears"></i>&nbsp;@lang('main.user:permissions_tab_label')</a></li>
                    @endif
                </ul>

                <div class="tab-content">

                    <!-- Содержимое таба Настройки -->
                    <div class="tab-pane fade in active" id="tab_user_properties">
                        <form method="post" action="/users/save">
                            <?php $csrfField = csrf_field(); echo $csrfField;?>
                            @if (isset($crmuser))
                            <input type="hidden" name="user_id" id="sc_user_id" value="{{$crmuser->user_id}}">
                            @endif

                            <div class="col-md-6">
                                <label for="usr_name">@lang('main.user:name_label')</label>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $old = old('name');
                                if (!is_null($old)) {
                                    $value = $old;
                                } elseif (isset($crmuser)) {
                                    $value = $crmuser->name;
                                } else {
                                    $value = '';
                                }?>
                                {{ Form::text('name', $value, ['id' => 'usr_name', 'class' => 'form-control']) }}
                                @foreach ($errors->get('name') as $message)
                                <br/>{{$message}}
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                <label for="usr_info">@lang('main.user:info_label')</label>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $old = old('info');
                                if (!is_null($old)) {
                                    $value = $old;
                                } elseif (isset($crmuser)) {
                                    $value = $crmuser->info;
                                } else {
                                    $value = '';
                                }?>
                                {{ Form::text('info', $value, ['id' => 'usr_info', 'class' => 'form-control']) }}
                                @foreach ($errors->get('info') as $message)
                                <br/>{{$message}}
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                <label for="usr_email">@lang('main.user:email_label')</label>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $old = old('email');
                                if (!is_null($old)) {
                                    $value = $old;
                                } elseif (isset($crmuser)) {
                                    $value = $crmuser->email;
                                } else {
                                    $value = '';
                                }?>
                                {{ Form::text('email', $value, ['id' => 'usr_email', 'class' => 'form-control', 'placeholder' => trans('adminlte_lang::message.example').'info@mail.com']) }}
                                @foreach ($errors->get('email') as $message)
                                <br/>{{$message}}
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                <label for="usr_phone">@lang('main.user:phone_label')</label>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $old = old('phone');
                                if (!is_null($old)) {
                                    $value = $old;
                                } elseif (isset($crmuser)) {
                                    $value = $crmuser->phone;
                                } else {
                                    $value = '';
                                }?>
                                {{ Form::text('phone', $value, ['id' => 'usr_phone', 'class' => 'form-control', 'placeholder' => trans('adminlte_lang::message.example').'7 495 232 20 00']) }}
                                @foreach ($errors->get('phone') as $message)
                                <br/>{{$message}}
                                @endforeach
                            </div>

                            @if(!isset($crmuser))
                            <div class="col-md-6">
                                <label for="usr_password">@lang('main.user:password_label')</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="password" class="form-control" id="usr_password">
                                @foreach ($errors->get('password') as $message)
                                <br/>{{$message}}
                                @endforeach
                            </div>
                            @endif
                            <div class="col-md-12 text-right m-t">
                                <button type="submit" class="btn btn-primary">@lang('main.btn_submit_label')</button>
                            </div>
                            <div class="col-md-4 col-md-offset-4" id="app_client_info_container"></div>
                        </form>
                    </div>



                    <!-- Содержимое вкладки Права доступа -->
                    @if(isset($crmuser))
                    <div class="tab-pane fade" id="tab_user_permissions">
                        <form method="post" action="/users/{{$crmuser->user_id}}/savePermissions">
                            {{$csrfField}}

                            <input type="hidden" name="user_id" id="permissions_user_id" value="{{$crmuser->user_id}}">

                            @if ($curruser->is_admin)
                            <?php
                            $selected = '';
                            if (isset($crmuser) AND $crmuser->is_admin) {
                                $selected = "checked='checked'";
                            }?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_admin" value="1" {{$selected}}><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <strong>@lang('main.user:permissions_is_admin')</strong>
                                </label>
                            </div>
                            @endif

                            <!-- Права доступа к форме Записей -->
                            <div>
                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'appointment_form' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="appointment_form_view" value="1" {{$selected}}><strong>@lang('main.user:permissions_appointment_form_label')</strong>
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'appointment' AND $permission->action == 'create' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="appointment_create" value="1" {{$selected}}>@lang('main.user:permissions_appointment_create_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'appointment' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="appointment_edit" value="1" {{$selected}}>@lang('main.user:permissions_appointment_edit_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'appointment' AND $permission->action == 'delete' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="appointment_delete" value="1" {{$selected}}>@lang('main.user:permissions_appointment_delete_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'appointment_client_data' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="appointment_client_data_view" value="1" {{$selected}}>@lang('main.user:permissions_appointment_client_data_label')
                                    </label>
                                </div>
                            </div>

                            <!-- Права доступа к настройкам -->
                            <div>
                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'settings' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="settings_view" value="1" {{$selected}}><strong>@lang('main.user:permissions_settings_label')</strong>
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'settings_manage_users' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="settings_manage_users_edit" value="1" {{$selected}}>@lang('main.user:settings_manage_users_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'service' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="service_edit" value="1" {{$selected}}>@lang('main.user:permissions_service_edit_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'service' AND $permission->action == 'delete' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="service_delete" value="1" {{$selected}}>@lang('main.user:permissions_service_delete_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'employee' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="employee_edit" value="1" {{$selected}}>@lang('main.user:permissions_employee_edit_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'employee' AND $permission->action == 'delete' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="employee_delete" value="1" {{$selected}}>@lang('main.user:permissions_employee_delete_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'schedule' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="schedule_edit" value="1" {{$selected}}>@lang('main.user:permissions_schedule_edit_label')
                                    </label>
                                </div>
                            </div>

                            <!-- Права доступа к клиентам -->
                            <div>
                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'clients' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="clients_view" value="1" {{$selected}}><strong>@lang('main.user:permissions_clients_label')</strong>
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'clients_phone' AND $permission->action == 'view' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="clients_phone_view" value="1" {{$selected}}>@lang('main.user:permissions_view_clients_phone_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'client_phone' AND $permission->action == 'view' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="client_phone_view" value="1" {{$selected}}>@lang('main.user:permissions_view_client_phone_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'clients_export_xls' AND $permission->action == 'view' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="clients_export_xls_view" value="1" {{$selected}}>@lang('main.user:permissions_clients_export_xls_label')
                                    </label>
                                </div>
                            </div>

                            <!-- Права доступа к финансам -->
                            <div>
                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'finances' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="finances_view" value="1" {{$selected}}><strong>@lang('main.user:permissions_finances_label')</strong>
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'wage_schemes' AND $permission->action == 'view' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="wage_schemes_view" value="1" {{$selected}}>@lang('main.user:permissions_wage_schemes_view_label')
                                    </label>
                                </div>

                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'wage_schemes' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="wage_schemes_edit" value="1" {{$selected}}>@lang('main.user:permissions_wage_schemes_edit_label')
                                    </label>
                                </div>
                            </div>

                            <!-- Права доступа к складам -->
                            <div>
                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'statistics' AND $permission->action == 'view' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="statistics_view" value="1" {{$selected}}><strong>@lang('main.user:permissions_statistics_label')</strong>
                                    </label>
                                </div>
                            </div>

                            <!-- Права доступа к складам -->
                            <div>
                                <?php
                                $selected = '';
                                if (isset($crmuser)) {
                                    foreach($crmuser->accessPermissions()->get() AS $permission) {
                                        if ($permission->object == 'storages' AND $permission->access_level == '1') {
                                            $selected = "checked='checked'";
                                        }
                                    }
                                }?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="storages_view" value="1" {{$selected}}><strong>@lang('main.user:permissions_storages_label')</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 text-right m-t">
                                <button type="submit" class="btn btn-primary">@lang('main.btn_submit_label')</button>
                            </div>
                        </form>
                    </div>
                    @endif


                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
