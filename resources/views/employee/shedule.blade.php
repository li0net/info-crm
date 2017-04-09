<div class="col-md-4">
    <div class="input-group" >
        <input type='hidden' id='sheduleWeek' name='sheduleWeek' placeholder="Select Week" />
        <input type='hidden' id='employee_id' name='employee_id' value="{{ $employee->employee_id }}" />
        <div id="shedule_week" class="datepicker-week datepicker-white"></div>
    </div>
</div>
<div class="col-md-12">
    <div class="ui-datepicker operating_schedule" style="display:block;width:720px!important;">
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
                    <span title="Весь день">Пн</span>
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
                    <span title="Весь день">Вт</span>
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
                    <span title="Весь день">Ср</span>
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
                    <span title="Весь день">Чт</span>
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
                    <span title="Весь день">Пт</span>
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
                    <span title="Весь день">Сб</span>
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
                    <span title="Весь день">Вс</span>
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
    <div style="display:block;width:720px!important;" class="form-horizontal">
        <div class="form-group">
            {{ Form::label('name',trans('Скопировать график на'), ['class' => 'col-sm-4 control-label text-left']) }}
            <div class="col-sm-2">
                <select name="fill_weeks" id="fill_weeks" class="form-control">
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
            </div>
            {{ Form::label('name',trans('недель вперед'), ['class' => 'col-sm-3 control-label text-left']) }}
        </div>
        <div class="text-left">
            <a class="btn btn-link link-blue" id='shedule-clear' href="#" onclick="return false;">Очистить график на неделю</a>
        </div>
        <a class="btn btn-link link-blue" id='shedule-show' href="#" onclick="return false;">ИТОГ</a>
    </div>
</div>


<div class="schedule-help" style="display:none">
    ✔ В таблице снизу отображается расписание на неделю 03.04.2017 - 09.04.2017;
    <br><br>
    ✔ Каждый квадратик означает один рабочий час;
    <br><br>
    ✔ По горизонтали располагается шкала времени, а по вертикали дни недели. Кликайте по часам или дням для быстрого заполнения;
    <br><br>
    ✔ Вы можете абсолютно гибко изменять рабочий график. Главное не забывайте нажимать кнопку «Сохранить».
</div>

<!--{!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "id" => "employee_form__schedule"]) !!}-->
<!--{!! Form::close() !!}-->
<!--<div class="jumbotron">-->
<!--    <p class="lead">{{ trans('adminlte_lang::message.section_under_construction') }}</p>-->
<!--</div>-->
