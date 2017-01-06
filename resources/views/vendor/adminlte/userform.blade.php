@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.user:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if (isset($user))
                            @lang('main.user:edit_form_header')
                        @else
                            @lang('main.user:create_form_header')
                        @endif
                    </div>

                    <div class="panel-body">

                        <ul class="nav nav-pills nav-justified" id="user_tabs_header" role="tablist">
                            <li class="active"><a href="#tab_user_properties" role="tab" data-toggle="tab"><i class="fa address-book-o" aria-hidden="true"></i>&nbsp;@lang('main.user:properties_tab_label')</a></li>
                            @if(isset($user))
                            <li><a href="#tab_user_permissions" role="tab" data-toggle="pill"><i class="fa gears"></i>&nbsp;@lang('main.user:permissions_tab_label')</a></li>
                            @endif
                        </ul>

                        <div class="tab-content">

                            <!-- Содержимое таба Настройки -->
                            <div class="tab-pane fade in active" id="tab_user_properties">
                                <form method="post" action="/users/save">
                                    {{csrf_field()}}
                                    @if (isset($user))
                                        <input type="hidden" name="user_id" id="sc_user_id" value="{{$user->user_id}}">
                                    @endif

                                    <div class="col-md-6">
                                        <label for="usr_name">@lang('main.user:name_label')</label>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        $old = old('name');
                                        if (!is_null($old)) {
                                            $value = $old;
                                        } elseif (isset($user)) {
                                            $value = $user->name;
                                        } else {
                                            $value = '';
                                        }?>
                                        <input type="text" name="name" id="usr_name" value="{{$value}}">
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
                                        } elseif (isset($user)) {
                                            $value = $user->info;
                                        } else {
                                            $value = '';
                                        }?>
                                        <input type="text" name="info" id="usr_info" value="{{$value}}">
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
                                        } elseif (isset($user)) {
                                            $value = $user->email;
                                        } else {
                                            $value = '';
                                        }?>
                                        <input type="text" name="email" id="usr_email" value="{{$value}}">
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
                                        } elseif (isset($user)) {
                                            $value = $user->phone;
                                        } else {
                                            $value = '';
                                        }?>
                                        <input type="text" name="phone" id="usr_phone" value="{{$value}}">
                                        @foreach ($errors->get('phone') as $message)
                                            <br/>{{$message}}
                                        @endforeach
                                    </div>

                                    <div class="col-md-12">
                                        <hr/>
                                        <button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
                                    </div>

                                    <div class="col-md-4 col-md-offset-4" id="app_client_info_container">
                                    </div>


                                </form>
                            </div>



                            <!-- Содержимое вкладки Права доступа -->
                            @if(isset($user))
                            <div class="tab-pane fade" id="tab_user_permissions">
                                <form method="post" action="/users/{{$user->user_id}}/savePermissions">
                                    {{csrf_field()}}

                                    <input type="hidden" name="user_id" id="permissions_user_id" value="{{$user->user_id}}">

                                    <!-- Права доступа к форме Записей -->
                                    <div>
                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'appointment_form' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="appointment_form_view" value="1" {{$selected}}><strong>@lang('main.user:permissions_appointment_form_label')</strong></p>

                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'appointment' AND $permission->action == 'create' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="appointment_create" value="1" {{$selected}}>@lang('main.user:permissions_appointment_create_label')</p>

                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'appointment' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="appointment_edit" value="1" {{$selected}}>@lang('main.user:permissions_appointment_edit_label')</p>

                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'appointment' AND $permission->action == 'delete' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="appointment_delete" value="1" {{$selected}}>@lang('main.user:permissions_appointment_delete_label')</p>

                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'appointment_client_data' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="appointment_client_data_view" value="1" {{$selected}}><strong>@lang('main.user:permissions_appointment_client_data_label')</strong></p>
                                    </div>

                                    <!-- Права доступа к настройкам -->
                                    <div>
                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'settings' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="settings_view" value="1" {{$selected}}><strong>@lang('main.user:permissions_settings_label')</strong></p>

                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'settings_manage_users' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="settings_manage_users_edit" value="1" {{$selected}}>@lang('main.user:permissions_settings_label')</p>

                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'service' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="service_edit" value="1" {{$selected}}>@lang('main.user:permissions_service_edit_label')</p>

                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'service' AND $permission->action == 'delete' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="service_delete" value="1" {{$selected}}>@lang('main.user:permissions_service_delete_label')</p>

                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'employee' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="employee_edit" value="1" {{$selected}}>@lang('main.user:permissions_employee_edit_label')</p>

                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'employee' AND $permission->action == 'delete' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="employee_delete" value="1" {{$selected}}>@lang('main.user:permissions_employee_delete_label')</p>

                                        <?php
                                        $selected = '';
                                        if (isset($user)) {
                                            foreach($user->accessPermissions() AS $permission) {
                                                if ($permission->object == 'schedule' AND $permission->action == 'edit' AND $permission->access_level == '1') {
                                                    $selected = "selected='selected'";
                                                }
                                            }
                                        }?>
                                        <p><input type="checkbox" name="schedule_edit" value="1" {{$selected}}>@lang('main.user:permissions_schedule_edit_label')</p>
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
    </div>
    </div>
@endsection
