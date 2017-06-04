<?php $accessLevel = $crmuser->hasAccessTo('wage_schemes', 'edit', 0); ?>
@if($accessLevel > 0)
    <form id="employee_form__wage" method="post" action="/employees/saveWageScheme">
        {{csrf_field()}}
        <input type="hidden" name="employee_id" id="ws_employee_id" value="{{$employee->employee_id}}">
        <!-- // выбор схемы расчета зп -->
        <div class="form-group">
            <label for="ws_wage_scheme_id" class="col-sm-4 text-right ctrl-label">@lang('main.employee:wage_scheme_label')</label>
            <div class="col-sm-7">
                <select name="wage_scheme_id" id="ws_wage_scheme_id" class="js-select-basic-single" >
                    @foreach($wageSchemeOptions AS $wageScheme)
                        <option
                                @if(old('wage_scheme_id') AND old('wage_scheme_id') == $wageScheme['value'])
                                selected="selected"
                                @elseif(!old('wage_scheme_id') AND isset($employee))
                                <?php $ws = $employee->wageSchemes()->first();?>
                                @if($ws AND $ws->scheme_id == $wageScheme['value'])
                                selected="selected"
                                @endif
                                @endif

                                value="{{$wageScheme['value']}}">{{$wageScheme['label']}}</option>
                    @endforeach
                </select>
                @foreach ($errors->get('wage_scheme_id') as $message)
                    <br/>{{$message}}
                @endforeach
            </div>
        </div>

        <!-- выбор даты с которой схема начинает действовать -->
        <div class="form-group">
            <label for="ws_scheme_start" class="hasDatepicker col-sm-4 text-right ctrl-label">@lang('main.employee:wage_scheme_start_from_label')</label>
            <div class="col-sm-7">
                <div class="input-group">
                    <?php
                    $old = old('scheme_start');
                    $value = '';
                    if (!is_null($old)) {
                        $value = $old;
                    } elseif (isset($employee)) {
                        $currWs = $employee->wageSchemes()->first();
                        if ($currWs) {
                            $value = date('Y-m-d', strtotime($currWs->pivot->scheme_start));
                        }
                    }?>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" class="form-control" name="scheme_start" id="ws_scheme_start" value="{{$value}}" placeholder="@lang('main.employee:wage_scheme_start_from_label')">
                    @foreach ($errors->get('scheme_start') as $message)
                        <br/>{{$message}}
                    @endforeach
                </div>
            </div>
        </div>
    </form>

@endif