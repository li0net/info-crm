/** СТАРЫЕ СКРИПТЫ ИЗ РАЗНЫХ ФАЙЛОВ -- УДАЛИТЬ ЗА НЕНАДОБНОСТЬЮ **/
$('#date-from').datepicker({
    language: $('#current_lang').html(),
    autoclose: true,
    orientation: 'auto',
    format: 'dd-mm-yyyy',
    weekStart: 1
});
$('#date-to').datepicker({
    language: $('#current_lang').html(),
    autoclose: true,
    orientation: 'auto',
    format: 'dd-mm-yyyy',
    weekStart: 1
});
$('#filter-date-from').datepicker({
    autoclose: true,
    orientation: 'auto',
    format: 'dd-mm-yyyy',
    weekStart: 1
});
$('#filter-date-to').datepicker({
    autoclose: true,
    orientation: 'auto',
    format: 'dd-mm-yyyy',
    weekStart: 1
});
// APPOINTMENT FORM
$('#app_date_from').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    firstDay: 1
});
$('#ws_scheme_start').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    firstDay: 1
});
// CLIENT form
$('#c_birthday').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    firstDay: 1
});
$('#e_wage_month').datepicker({
    language: $('#current_lang').html(),
    autoclose: true,
    format: 'yyyy-mm',
    minViewMode: 'months'
});
$('#dp').datepicker({
    language: $('#current_lang').html(),
    format: 'yyyy-mm-dd',
    startDate: '19/01/2017'
});
$('#app_call_date').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    firstDay: 1
});
$(function () {
    $.fn.datepicker.dates['ru'] = {
        days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
        daysShort: ["Вск", "Пнд", "Втр", "Срд", "Чтв", "Птн", "Суб"],
        daysMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
        months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
        monthsShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
        today: "Сегодня",
        clear: "Очистить",
        format: "dd.mm.yyyy",
        weekStart: 1,
        monthsTitle: 'Месяцы'
    };
});
$('#dp').datepicker({
    language: 'ru',
    format: 'yyyy-mm-dd',
    startDate: '19/01/2017'
});
