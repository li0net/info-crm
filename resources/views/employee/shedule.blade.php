<div class="col-md-4">
    <div class="input-group" >
        <input type='text' id='sheduleWeek' name='sheduleWeek' placeholder="Select Week" />
        <div id="shedule_week" class="datepicker-week datepicker-white"></div>
    </div>
</div>
<div class="col-md-12">
    <div class="ui-datepicker operating_schedule" style="display:block;width:720px!important;">
        <table id="operating_schedule" class="table-shedule ">
            <thead>
            <tr><th>&nbsp;</th>
                <th onclick="ms.salon.hour_select(0)"><span title="Каждый день в 0:00 ">0<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(1)"><span title="Каждый день в 1:00 ">1<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(2)"><span title="Каждый день в 2:00 ">2<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(3)"><span title="Каждый день в 3:00 ">3<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(4)"><span title="Каждый день в 4:00 ">4<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(5)"><span title="Каждый день в 5:00 ">5<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(6)"><span title="Каждый день в 6:00 ">6<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(7)"><span title="Каждый день в 7:00 ">7<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(8)"><span title="Каждый день в 8:00 ">8<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(9)"><span title="Каждый день в 9:00 ">9<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(10)"><span title="Каждый день в 10:00 ">10<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(11)"><span title="Каждый день в 11:00 ">11<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(12)"><span title="Каждый день в 12:00 ">12<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(13)"><span title="Каждый день в 13:00 ">13<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(14)"><span title="Каждый день в 14:00 ">14<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(15)"><span title="Каждый день в 15:00 ">15<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(16)"><span title="Каждый день в 16:00 ">16<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(17)"><span title="Каждый день в 17:00 ">17<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(18)"><span title="Каждый день в 18:00 ">18<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(19)"><span title="Каждый день в 19:00 ">19<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(20)"><span title="Каждый день в 20:00 ">20<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(21)"><span title="Каждый день в 21:00 ">21<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(22)"><span title="Каждый день в 22:00 ">22<em class="zeros"></em></span></th>
                <th onclick="ms.salon.hour_select(23)"><span title="Каждый день в 23:00 ">23<em class="zeros"></em></span></th>
            </tr></thead>
            <tbody>
            <tr>
                <td class="legend" onclick="ms.salon.day_select(0)">
                    <span title="Весь день">Пн</span>
                </td>
                <td day="0" hour="0" onclick="ms.salon.dayhour_select(this);" class="ui-datepicker-current-day">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="1" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="2" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="3" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="4" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="5" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="6" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="7" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="8" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="9" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="10" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="11" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="12" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="13" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="14" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="15" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="16" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="17" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="18" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="19" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="20" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="21" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="22" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="0" hour="23" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
            </tr>
            <tr>
                <td class="legend" onclick="ms.salon.day_select(1)">
                    <span title="Весь день">Вт</span>
                </td>
                <td day="1" hour="0" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="1" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="2" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="3" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="4" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="5" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="6" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="7" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="8" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="9" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="10" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="11" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="12" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="13" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="14" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="15" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="16" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="17" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="18" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="19" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="20" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="21" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="22" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="1" hour="23" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
            </tr>
            <tr>
                <td class="legend" onclick="ms.salon.day_select(2)">
                    <span title="Весь день">Ср</span>
                </td>
                <td day="2" hour="0" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="1" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="2" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="3" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="4" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="5" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="6" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="7" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="8" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="9" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="10" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="11" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="12" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="13" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="14" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="15" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="16" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="17" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="18" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="19" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="20" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="21" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="22" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="2" hour="23" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
            </tr>
            <tr>
                <td class="legend" onclick="ms.salon.day_select(3)">
                    <span title="Весь день">Чт</span>
                </td>
                <td day="3" hour="0" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="1" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="2" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="3" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="4" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="5" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="6" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="7" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="8" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="9" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="10" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="11" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="12" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="13" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="14" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="15" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="16" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="17" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="18" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="19" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="20" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="21" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="22" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="3" hour="23" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
            </tr>
            <tr>
                <td class="legend" onclick="ms.salon.day_select(4)">
                    <span title="Весь день">Пт</span>
                </td>
                <td day="4" hour="0" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="1" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="2" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="3" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="4" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="5" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="6" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="7" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="8" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="9" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="10" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="11" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="12" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="13" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="14" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="15" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="16" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="17" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="18" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="19" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="20" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="21" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="22" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="4" hour="23" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
            </tr>
            <tr>
                <td class="legend" onclick="ms.salon.day_select(5)">
                    <span title="Весь день">Сб</span>
                </td>
                <td day="5" hour="0" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="1" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="2" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="3" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="4" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="5" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="6" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="7" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="8" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="9" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="10" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="11" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="12" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="13" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="14" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="15" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="16" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="17" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="18" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="19" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="20" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="21" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="22" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="5" hour="23" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
            </tr>
            <tr>
                <td class="legend" onclick="ms.salon.day_select(6)">
                    <span title="Весь день">Вс</span>
                </td>
                <td day="6" hour="0" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="1" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="2" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="3" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="4" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="5" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="6" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="7" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="8" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="9" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="10" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="11" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="12" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="13" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="14" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="15" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="16" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="17" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="18" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="19" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="20" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="21" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="22" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
                <td day="6" hour="23" onclick="ms.salon.dayhour_select(this);">
                    <a href="#" class="ui-state-default" onclick="return false"></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="schedule_pattern ui-corner-all">
        Скопировать график на&nbsp;
        <select name="repeat" class="">
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
        &nbsp;недель вперед	<a class="btn btn-link link-blue pull-right" href="#" onclick="ms.salon.work_clear(); return false;">
            Очистить график на неделю	</a>
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
