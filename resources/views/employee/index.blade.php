@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.employees') }}
@endsection

@section('main-content')

<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.employees') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.employees') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12 text-right">
            <a href="{{ route('employee.create') }}" class="btn btn-primary">{{ trans('adminlte_lang::message.employee_create_new') }}</a>
        </div>
        <div class="col-sm-12">
            <hr>
        </div>
    </div>

    <form method="post" action="/employee" class="form">
        {{ csrf_field() }}
        {{ Form::hidden('organization_id', $user->organization_id, ['id' => 'organization_id']) }}
        <fieldset>
            <div class="row m-b">
                <div class="col-sm-4">
                    {{ Form::select(
                        'position_id',
                        $positions,
                        null,
                        [
                            'class' => 'js-select-basic-single',
                            'required' => '',
                            'id' => 'position_id',
                            'placeholder' => trans('adminlte_lang::message.position_not_chosen')
                        ])
                    }}
                </div>
                <div class="col-sm-4">
                    {{ Form::select(
                        'is_deleted',
                        [1 => trans('adminlte_lang::message.deleted'), 2 => trans('adminlte_lang::message.not_deleted')],
                        null,
                        [
                            'class' => 'js-select-basic-single',
                            'required' => '',
                            'id' => 'is_deleted',
                            'placeholder' => trans('adminlte_lang::message.all')
                        ])
                    }}
                </div>
                <div class="col-sm-4">
                    {{ Form::select(
                        'is_fired',
                        [1 => trans('adminlte_lang::message.fired'), 2 => trans('adminlte_lang::message.not_fired')],
                        2,
                        [
                            'class' => 'js-select-basic-single',
                            'required' => '',
                            'id' => 'is_fired',
                            'placeholder' => trans('adminlte_lang::message.all')
                        ])
                    }}
                </div>
            </div>
            <div class="row m-b ">
                <div class="col-sm-12 text-right">
                    <input type="button" class="btn btn-primary" value={{ trans('adminlte_lang::message.show') }} id='form_submit'>
                </div>
            </div>
        </fieldset>
    </form>
    <div class="row m-t">
        <div class="col-sm-12" id="result_container">
            <table class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th></th>
                    <th>{{ trans('adminlte_lang::message.employee_name') }}</th>
                    <th>{{ trans('adminlte_lang::message.employee_email') }}</th>
                    <th>{{ trans('adminlte_lang::message.employee_phone') }}</th>
                    <th>{{ trans('adminlte_lang::message.employee_position') }}</th>
                    <th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $employee)
                <tr>
                    <th class="text-center">{{ $employee->employee_id }}</th>
                    <td class="text-center">
                        @if( $employee->avatar_image_name != null)
                            <img src="/images/{{ $employee->avatar_image_name }}" class="img-circle img-circle-small ">
                        @else
                            <img src="/img/crm/avatar/avatar100.jpg" alt=""  class="img-circle img-circle-small ">
                        @endif
                    </td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->position->title }}</td>

                    <td class="text-center">
                        <a href="{{ route('employee.show', $employee->employee_id) }}" class="table-action-link"><i class='fa fa-eye'></i></a>
                        @if ($user->hasAccessTo('employee', 'edit', 0))
                        <a href="{{ route('employee.edit', $employee->employee_id) }}#info" id="employee_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
                        @endif
                        <a href="{{ route('employee.edit', $employee->employee_id) }}#services" class="table-action-link"><i class='fa fa-tags'></i></a>
                        <a href="{{ route('employee.edit', $employee->employee_id) }}#schedule" class="table-action-link"><i class='fa fa-calendar'></i></a>
                        <a href="{{ route('employee.edit', $employee->employee_id) }}#settings" class="table-action-link"><i class='fa fa-cog'></i></a>
                        <a href="{{ route('employee.edit', $employee->employee_id) }}#payroll" class="table-action-link"><i class="fa fa-money"></i></a>
                        @if ($user->hasAccessTo('employee', 'delete', 0))
                            {!! Form::open(['route' => ['employee.destroy', $employee->employee_id], 'id' => 'form'.$employee->employee_id, 'style' => 'max-width: 32px; margin:0; padding:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
                                <a href="javascript: submitform('#form{{$employee->employee_id}}')" class="table-action-link danger-action"><i class='fa fa-trash-o'></i></a>
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {!! $employees->render() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
    <script>
        $(document).ready(function() {
            $('#result_container').on('click', '.filtered > .pagination', function(e) {
                var page = 0;
                if ($(e.target).html() == '»') {
                    page = parseInt($('.pagination li.active span').html()) + 1;
                } else if ($(e.target).html() == '«'){
                    page = parseInt($('.pagination li.active span').html()) - 1;
                } else {
                    page = parseInt($(e.target).html());
                }

                $.ajax({
                    type: "POST",
                    dataType: 'html',
                    data: {
                        'position_id'       : $('#position_id').val(),
                        'is_deleted'        : $('#is_deleted').val(),
                        'is_fired'          : $('#is_fired').val(),
                        'organization_id'   : $('#organization_id').val(),
                        'page'              : page
                    },
                    url: "/employee/list",
                    success: function(data) {
                        $('#result_container').html(data);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Error while processing payments data range!');
                    }
                });

                return false;
            });

            $('#form_submit').on('click', function(e){
                $.ajax({
                    type: "POST",
                    dataType: 'html',
                    data: {
                        'position_id'       : $('#position_id').val(),
                        'is_deleted'        : $('#is_deleted').val(),
                        'is_fired'          : $('#is_fired').val(),
                        'organization_id'   : $('#organization_id').val()
                    },
                    url: "/employee/list",
                    success: function(data) {
                        $('#result_container').html(data);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Error while processing payments data range!');
                    }
                });
            });
        });
    </script>
@endsection

<script>
    function submitform(form_id) {
        $(form_id).submit();
    }
</script>