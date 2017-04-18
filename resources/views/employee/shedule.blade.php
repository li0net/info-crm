{!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "id" => "employee_form__schedule"]) !!}
    <div class="row">
        <div class="col-md-4">
            <div class="input-group" >
                <input type='hidden' id='employee_id' name='employee_id' value="{{ $employee->employee_id }}" />
                <input type='hidden' id='sheduleWeek' name='sheduleWeek' placeholder="Select Week" />
                <div id="shedule_week" class="datepicker-week datepicker-white"></div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="help-block">
                <ul class="schedule-help">
                    <li>{{ trans('adminlte_lang::message.employee_help_1') }}</li>
                    <li>{{ trans('adminlte_lang::message.employee_help_2') }}</li>
                    <li>{{ trans('adminlte_lang::message.employee_help_3') }}</li>
                    <li>{{ trans('adminlte_lang::message.employee_help_4') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr/>
        </div>
        <div class="col-md-12">
            <div class="ui-datepicker operating_schedule">
                <table id="operating_schedule" class="table-shedule ">
                    <thead>
                    <tr><th>&nbsp;</th>
                        <th data-head-hour="0"><span >0<em class="zeros"></em></span></th>
                        <th data-head-hour="1"><span >1<em class="zeros"></em></span></th>
                        <th data-head-hour="2"><span >2<em class="zeros"></em></span></th>
                        <th data-head-hour="3"><span >3<em class="zeros"></em></span></th>
                        <th data-head-hour="4"><span >4<em class="zeros"></em></span></th>
                        <th data-head-hour="5"><span >5<em class="zeros"></em></span></th>
                        <th data-head-hour="6"><span >6<em class="zeros"></em></span></th>
                        <th data-head-hour="7"><span >7<em class="zeros"></em></span></th>
                        <th data-head-hour="8"><span >8<em class="zeros"></em></span></th>
                        <th data-head-hour="9"><span >9<em class="zeros"></em></span></th>
                        <th data-head-hour="10"><span>10<em class="zeros"></em></span></th>
                        <th data-head-hour="11"><span>11<em class="zeros"></em></span></th>
                        <th data-head-hour="12"><span>12<em class="zeros"></em></span></th>
                        <th data-head-hour="13"><span>13<em class="zeros"></em></span></th>
                        <th data-head-hour="14"><span>14<em class="zeros"></em></span></th>
                        <th data-head-hour="15"><span>15<em class="zeros"></em></span></th>
                        <th data-head-hour="16"><span>16<em class="zeros"></em></span></th>
                        <th data-head-hour="17"><span>17<em class="zeros"></em></span></th>
                        <th data-head-hour="18"><span>18<em class="zeros"></em></span></th>
                        <th data-head-hour="19"><span>19<em class="zeros"></em></span></th>
                        <th data-head-hour="20"><span>20<em class="zeros"></em></span></th>
                        <th data-head-hour="21"><span>21<em class="zeros"></em></span></th>
                        <th data-head-hour="22"><span>22<em class="zeros"></em></span></th>
                        <th data-head-hour="23"><span>23<em class="zeros"></em></span></th>
                    </tr></thead>
                    <tbody>
                    <tr>
                        <td class="legend" data-head-day="0">
                            <span title="{{ trans('adminlte_lang::message.all_day') }}">{{ trans('adminlte_lang::message.mo') }}</span>
                        </td>
                        <td data-day="0" data-hour="0"  class="ui-datepicker-current-day">
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="1" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="2" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="3" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="4" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="5" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="6" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="7" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="8" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="9" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="10" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="11" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="12" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="13" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="14" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="15" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="16" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="17" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="18" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="19" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="20" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="21" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="22" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="0" data-hour="23" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="legend" data-head-day="1">
                            <span title="{{ trans('adminlte_lang::message.all_day') }}">{{ trans('adminlte_lang::message.tu') }}</span>
                        </td>
                        <td data-day="1" data-hour="0" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="1" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="2" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="3" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="4" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="5" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="6" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="7" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="8" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="9" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="10" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="11" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="12" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="13" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="14" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="15" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="16" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="17" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="18" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="19" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="20" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="21" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="22" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="1" data-hour="23" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="legend" data-head-day="2">
                            <span title="{{ trans('adminlte_lang::message.all_day') }}">{{ trans('adminlte_lang::message.we') }}</span>
                        </td>
                        <td data-day="2" data-hour="0" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="1" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="2" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="3" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="4" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="5" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="6" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="7" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="8" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="9" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="10" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="11" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="12" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="13" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="14" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="15" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="16" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="17" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="18" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="19" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="20" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="21" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="22" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="2" data-hour="23" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="legend" data-head-day="3">
                            <span title="{{ trans('adminlte_lang::message.all_day') }}">{{ trans('adminlte_lang::message.th') }}</span>
                        </td>
                        <td data-day="3" data-hour="0" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="1" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="2" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="3" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="4" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="5" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="6" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="7" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="8" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="9" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="10" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="11" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="12" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="13" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="14" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="15" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="16" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="17" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="18" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="19" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="20" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="21" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="22" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="3" data-hour="23" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="legend" data-head-day="4">
                            <span title="{{ trans('adminlte_lang::message.all_day') }}">{{ trans('adminlte_lang::message.fr') }}</span>
                        </td>
                        <td data-day="4" data-hour="0" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="1" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="2" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="3" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="4" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="5" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="6" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="7" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="8" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="9" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="10" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="11" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="12" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="13" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="14" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="15" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="16" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="17" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="18" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="19" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="20" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="21" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="22" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="4" data-hour="23" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="legend" data-head-day="5">
                            <span title="{{ trans('adminlte_lang::message.all_day') }}">{{ trans('adminlte_lang::message.sa') }}</span>
                        </td>
                        <td data-day="5" data-hour="0" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="1" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="2" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="3" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="4" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="5" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="6" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="7" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="8" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="9" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="10" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="11" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="12" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="13" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="14" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="15" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="16" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="17" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="18" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="19" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="20" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="21" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="22" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="5" data-hour="23" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="legend" data-head-day="6">
                            <span title="{{ trans('adminlte_lang::message.all_day') }}">{{ trans('adminlte_lang::message.su') }}</span>
                        </td>
                        <td data-day="6" data-hour="0" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="1" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="2" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="3" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="4" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="5" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="6" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="7" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="8" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="9" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="10" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="11" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="12" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="13" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="14" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="15" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="16" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="17" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="18" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="19" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="20" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="21" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="22" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                        <td data-day="6" data-hour="23" >
                            <a href="#" class="ui-state-default" onclick="return false"></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div id="shedule-buttons" class="form-horizontal form-inline ">
                <div class="form-group pull-left">
                    <label class='control-label label-sm text-left'>
                        <i class="fa fa-clone" aria-hidden="true"></i>{{ trans('adminlte_lang::message.employee_copy_on') }}
                    </label>
                    <select name="fill_weeks" id="fill_weeks" class="form-control form-control-sm">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                    {{ Form::label('name',trans('adminlte_lang::message.employee_copy_on'), ['class' => 'control-label label-sm text-left']) }}
                </div>
                <a class="btn btn-link link-blue btn-link-sm pull-right" id='shedule-clear' href="#" onclick="return false;"><i class="fa fa-eraser" aria-hidden="true"></i>{{ trans('adminlte_lang::message.employee_clear_schedule') }}</a>
            </div>
        </div>
        <div class="col-md-12">
            <div class="alert alert-success" id="employee_form_success_alert">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                <span>@lang('main.user:mailings_settings_saved_message')</span>
            </div>
            <div class="alert alert-error" id="employeegs_form_error_alert">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                <span>@lang('main.user:mailings_settings_save_error_message')</span>
            </div>
        </div>
    </div>
{!! Form::close() !!}