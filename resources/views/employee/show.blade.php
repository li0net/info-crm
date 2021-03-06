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

        <div class="col-sm-12"><hr></div>
    </div>
    <div class="row form-horizontal">
        <div class="col-sm-12"><h2>Wages</h2></div>

        <div class="form-group col-sm-10">
            <label for="wage_month" class="col-sm-5 control-label text-right">Select month to calculate wage</label>
            <div class="col-sm-7">
                <!--<div class="input-group-addon"><i class="fa fa-calendar"></i></div>-->
                <input type="text" class="form-control hasDatepicker" name="wage_month" id="e_wage_month" value="{{date('Y-m')}}" placeholder="@lang('main.client:birthday_label')">
            </div>
        </div>
        <div class="col-sm-2 text-right">
            <a href="#" id="e_btn_calculate_wage" class="btn btn-info">Calculate wage</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 clients-grid-block">
            <table id="calculated_wages_grid" class="table table-hover table-condensed"></table>
            <div id="calculated_wages_grid_pager"></div>
        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
<script type="text/javascript">
var employeeId = '{{$employee->employee_id}}';

function gridPayCW(cwId) {
    if (typeof cwId == 'undefined') {
        return FALSE;
    }

    $.ajax({
        type: "GET",
        url: "/employees/payWage/"+cwId,
        data: "",
        dataType: 'json',
        success: function(data) {
            //var data = $.parseJSON(data);
            if ( console && console.log ) {
                console.log("Wage pay data:", data);
            }

            if (data.res == true) {
                $("#calculated_wages_grid").trigger("reloadGrid");
                alert('Wage marked as payed');
            } else {
                alert('Error: '+data.error);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert('Server error:'+textStatus);
            $('a#e_btn_calculate_wage').removeClass('disabled');
        }
    });
}

$(document).ready(function() {

    $("#calculated_wages_grid").jqGrid({
        url: '/employees/calculateWagesGridData/{{$employee->employee_id}}',
        mtype: "GET",
        styleUI: 'Bootstrap',
        datatype: "json",
        colNames: ['ID', 'Period start', 'Period end', 'Amount', 'Date payed', 'Pay'],
        colModel: [
            {index: 'cw_id', name: 'cw_id', key: true, width: 60, hidden: true, search: false},
            {index: 'wage_period_start', name: 'wage_period_start', width: 100, search: false},
            {index: 'wage_period_end', name: 'wage_period_end', width: 100, search: false},
            {index: 'total_amount', align:'left', name: 'total_amount', width: 70, search: false},
            {index: 'date_payed', align:'left', name: 'date_payed', width: 60, search: false},
            {index: 'pay_button', align:'left', name: 'pay_button', width: 60, search: false}
        ],
        sortname: 'wage_period_start',
        sortorder: 'desc',
        viewrecords: true,
        height: 250,
        autowidth: true,
        shrinkToFit: true,
        rowNum: 5,
        pager: "#calculated_wages_grid_pager",
        //multiselect: true,
        /*
        onSelectRow: function(id, status, e){
            //console.log(id, status, e);
            var selRows = $('#clients_grid').getGridParam('selarrrow');
            if (selRows.length > 0) {
                $('#a_clients_delete_selected').removeClass("disabled");
                $('#a_send_sms_to_selected').removeClass("disabled");
                $('#a_clients_add_selected_to_category').removeClass("disabled");
            } else {
                $('#a_clients_delete_selected').addClass("disabled");
                $('#a_send_sms_to_selected').addClass("disabled");
                $('#a_clients_add_selected_to_category').addClass("disabled");
            }
        },
        onSelectAll: function(aRowIds, status){
            //console.log(aRowIds, status);
            if (status == true) {
                $('#a_clients_delete_selected').removeClass("disabled");
                $('#a_send_sms_to_selected').removeClass("disabled");
                $('#a_clients_add_selected_to_category').removeClass("disabled");
            } else {
                $('#a_clients_delete_selected').addClass("disabled");
                $('#a_send_sms_to_selected').addClass("disabled");
                $('#a_clients_add_selected_to_category').addClass("disabled");
            }
        }
        */
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
                    $("#calculated_wages_grid").trigger("reloadGrid");
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