@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $employee->name }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.employee') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li><a href="{{ url('/employee') }}">{{ trans('adminlte_lang::message.employees') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.employee') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-2 text-center">
            <div class="logo-block">
                <div v-if="!image">
                    @if( $employee->avatar_image_name != null)
                    <img src="/images/{{ $employee->avatar_image_name }}" />
                    @else
                    <img src="/img/crm/avatar/avatar100.jpg" alt="">
                    @endif
                </div>
                <div v-else>
                    <img :src="image" />
                </div>
            </div>
        </div>
        <div class="col-sm-10">
            <dl class="dl-horizontal text-block">
                <dt>{{trans('adminlte_lang::message.employee')}}</dt>
                <dd>#{{ $employee->employee_id }}</dd>

                <dt>{{trans('adminlte_lang::message.employee_name')}}</dt>
                <dd>{{ $employee->name }}</dd>

                <dt>Email:</dt>
                <dd>{{ $employee->email }}</dd>

                <dt>{{ trans('adminlte_lang::message.employee_phone') }}</dt>
                <dd>{{ $employee->phone }}</dd>

                <dt>{{ trans('adminlte_lang::message.employee_position') }}</dt>
                <dd>{{ $employee->position->title }}</dd>
            </dl>
        </div>

        <h2>Wages</h2>
        <div class="form-group">
            <label for="wage_month" class="col-sm-3 control-label text-right">Select month to calculate wage</label>
            <div class="col-sm-9">
                <!--<div class="input-group-addon"><i class="fa fa-calendar"></i></div>-->
                <input type="text" class="form-control" name="wage_month" id="e_wage_month" value="{{date('Y-m')}}" placeholder="@lang('main.client:birthday_label')">
            </div>
        </div>
        <div class="col-sm-12 text-right">
            <a href="#" id="e_btn_calculate_wage" class="btn btn-primary">Calculate wage</a>
        </div>

        <div class="col-sm-12">
            @if ($user->hasAccessTo('employee', 'delete', 0))
                {!! Form::open(['route' => ['employee.destroy', $employee->employee_id], "method" => 'DELETE', "class" => 'pull-left m-r']) !!}
                {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger']) }}
                {!! Form::close() !!}
            @endif
            @if ($user->hasAccessTo('employee', 'edit', 0))
                {!! Html::linkRoute('employee.edit', trans('adminlte_lang::message.edit'), [$employee->employee_id], ['class'=>'btn btn-primary pull-left']) !!}
            @endif
        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
<script type="text/javascript">
var employeeId = '{{$employee->employee_id}}';
$(document).ready(function() {
    $('#e_wage_month').datepicker({
        autoclose: true,
        format: 'yyyy-mm',
        minViewMode: 'months'
    });

    $('a#e_btn_calculate_wage').click(function () {
        if ($('a#e_btn_calculate_wage').hasClass( "disabled" )) {
            return false;
        }
        if ($('#e_wage_month').val() == '') {
            alert('First select month');
        }
        //checkZeroLists(['e_wage_month']);

        $('a#e_btn_calculate_wage').addClass('disabled');
        $.ajax({
            type: "POST",
            url: "/employees/calculateWage",
            data: {'employee_id' : employeeId, 'month': $('#e_wage_month').val()},
            dataType: 'json',
            success: function(data) {
                //var data = $.parseJSON(data);
                if ( console && console.log ) {
                    console.log("Wage calculation data:", data);
                }

                if (data.res == true) {
                    //$("#clients_grid").trigger("reloadGrid");
                    alert('Wage for selected month calculated');
                } else {
                    alert('Error: '+data.error);
                }
                $('a#e_btn_calculate_wage').removeClass('disabled');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert('Server error:'+textStatus);
                $('a#e_btn_calculate_wage').removeClass('disabled');
            }
        });

    });
});
</script>
@endsection