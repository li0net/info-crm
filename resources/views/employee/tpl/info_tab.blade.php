{!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', 'class' => 'hidden form-horizontal', 'id' => 'employee_form__info', 'files' => 'true']) !!}
{!! Form::hidden('id', 'employee_form__info') !!}
<div class="col-sm-8">
    <div class="form-group">
        {{ Form::label('name',trans('adminlte_lang::message.employee_name'), ['class' => 'col-sm-4 control-label text-right']) }}
        <div class="col-sm-8">
            {{ Form::text('name', null, ['class' => 'text-left form-control', 'placeholder' => trans('adminlte_lang::message.name_example')]) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('position_id', trans('adminlte_lang::message.employee_position'), ['class' => 'col-sm-4 control-label text-right']) }}
        <div class="col-sm-8">
            {{ Form::select('position_id', $items, $employee->position_id, ['class' => 'js-select-basic-single', 'required' => '']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('spec', trans('adminlte_lang::message.employee_specialization'), ['class' => 'col-sm-4 control-label text-right']) }}
        <div class="col-sm-8">
            {{ Form::text('spec', null, ['class' => 'form-control', 'placeholder' => trans('adminlte_lang::message.specialization_example')]) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('descr', trans('adminlte_lang::message.description'), ['class' => 'col-sm-4 control-label text-right']) }}
        <div class="col-sm-8">
            {{ Form::textarea('descr', null, ['class' => 'form-control']) }}
        </div>
    </div>
</div>

<div class="col-sm-4 text-center">
    <label class="ctrl-label">{{ trans('adminlte_lang::message.photo') }}</label>
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
    <span class="btn btn-info btn-file">
                                    {{ trans('adminlte_lang::message.load_photo') }}<input type="file" name="avatar" @change="onFileChange">
                                </span>
</div>
{!! Form::close() !!}
</div>

<div id="services-tab" class="tab-pane fade">

    {!! Form::model($employee, ['route' => ['employee.update_services'], 'method' => 'POST', "id" => "employee_form__services"]) !!}

    {{ Form::hidden('employee_id', $employee->employee_id) }}

    <div class="row m-t">
        {{ Form::label('service', trans('adminlte_lang::message.service'), ['class' => 'col-sm-3 text-left small']) }}
        {{ Form::label('duration', trans('adminlte_lang::message.duration'), ['class' => 'col-sm-4 text-left small']) }}
        {{ Form::label('routing', trans('adminlte_lang::message.routing'), ['class' => 'col-sm-3 text-center small']) }}
    </div>
    <div class="row">
        <div class="col-sm-12"><hr></div>
    </div>
    <div class="service-content m-b alt-control-bar">
        @if (isset($employee))
            @foreach($employee_attached_services as $employee_attached_service)
                <div class="row">
                    <div class="col-sm-3">
                        {{ Form::select(
                        'employee-service[]',
                        $employee_services,
                        $employee_attached_service->pivot->service_id,
                        [
                            'class' => 'js-select-basic-single',
                            'required' => '',
                            'data-initial-value' => $employee_attached_service->pivot->service_id
                        ])
                        }}
                    </div>
                    <div class="col-sm-2">
                        {{ Form::select(
                        'service-duration-hour[]',
                        $service_duration_hours,
                        date_parse($employee_attached_service->pivot->duration)['hour'],
                        ['class' => 'js-select-basic-single-alt', 'required' => ''])
                        }}
                    </div>
                    <div class="col-sm-2">
                        {{ Form::select(
                        'service-duration-minute[]',
                        $service_duration_minutes,
                        date_parse($employee_attached_service->pivot->duration)['minute'],
                        ['class' => 'js-select-basic-single-alt', 'required' => ''])
                        }}
                    </div>
                    <div class="col-sm-3">
                        {{ Form::select(
                        'service-routing[]',
                        $service_routings,
                        $employee_attached_service->pivot->routing_id,
                        [
                        'class' => 'js-select-basic-single-alt',
                        'required' => '',
                        'data-initial-value' => $employee_attached_service->pivot->routing_id
                        ])
                        }}
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="delete-employee" class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>
                        </button>

                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="row">
        <div class="col-sm-10 text-right">
            <input type="button" id="add-service" class="btn btn-info" value="{{ trans('adminlte_lang::message.service_add') }}">
        </div>
    </div>
{!! Form::close() !!}