//TODO ПЕРЕПИСАТЬ НА VUE

// set variables
var data;
var categoryId = '';
var serviceId = '';
var employeeId = '';
var date = '';
var time = '';
var tabs = 0;
var activeTab = 0;

$(document).ready(function() {
    /** первоначальная загрузка контента */
    $("#tab0").load( "/api/v1/widget/getDivisions", {sid:sid, org_id:orgId}, function() {
        $('#content').removeClass('loadingbox');
    });

    /** Карусель для переключения состояний экрана виджета */
    $('#wgCarousel').carousel({
        interval:   false
    });
    var clickEvent = false;
    $('#wgCarousel').on('click', '.nav a', function() {
        clickEvent = true;
        $('.nav li').removeClass('active');
        $(this).parent().addClass('active');
    }).on('slid.bs.carousel', function(e) {
        if(!clickEvent) {
            var count = $('.nav').children().length -1;
            var current = $('.nav li.active');
            current.removeClass('active').next().addClass('active');
            var id = parseInt(current.data('slide-to'));
            if(count == id) {
                $('.nav li').first().addClass('active');
            }
        }
        clickEvent = false;
    });

    /** расширение структуры таб-карусели при отрисовке нового экрана виджета */
    function updateTabs(tabName, icon) {
        $('#content').addClass('loadingbox');

        //елси пользователь вернулся к предыдущему шагу
        // и выбирает новые значения - выбранное
        if ( activeTab < tabs ) {
            console.log('повторный клик');
            console.log('activeTab:'+activeTab+' tabs:'+tabs);
            for (i=activeTab+1; i<=tabs; i++){
                console.log('- delete #crumb'+i + " #tab"+i);
                $('#content').find("#crumb"+i).remove();
                $('#content').find("#tab"+i).remove();
            }
            tabs = activeTab;
        }

        // показываем кнопку предыдущего таба с отображением выбранного занчения
        $('#wgCarousel').find('#crumb'+tabs+' a').html('<i class="fa ' + icon + ' " aria-hidden="true"></i>'+tabName);
        $('#wgCarousel').find('#crumb'+tabs).removeClass('hidden');

        // инкремент количества табов
        tabs++;

        // отображаем ссылку на инфо-страницу организации
        $(".info-link").show();

        // добавляем для нового экрана таб и кнопку(пока скрытую)

        $('#wgCarousel').find('ul.nav').append('<li data-target="#wgCarousel" class="hidden" id="crumb'+tabs+'" data-slide-to="'+tabs+'"><a href="#"></a></li>');
        $('#wgCarousel').find('.carousel-inner').append('<div class="item" id="tab'+tabs+'" data-id="'+tabs+'"></div>');
    }

    /**
     *  Выбрана организация, получаем экран с категориями
     */
    $('#content').on('click', 'a.division-row', function(){
        orgId = $(this).data('id');

        activeTab = $(this).parents('.item').data('id');
        console.log('activeTab:'+activeTab+' tabs:'+tabs);

        updateTabs($(this).data('name'),'fa-flag');

        $(".address").html( "<div>" + $(this).data('address') + '<br>' + $(this).data('phone') + "</div>" ).removeClass('hidden');
        $(".orgname-link").html($(this).data('name'));


        $('#wgCarousel').find("#tab"+tabs).load( "/api/v1/widget/getCategories",  {sid:sid, org_id:orgId},  function() {
            $('#content').removeClass('loadingbox');
            $('#wgCarousel').carousel(tabs);
        });
    });

    /**
     *  Выбрана категория, подгружаем экран с услугами
     */
    $('#content').on('click', 'a.category-row', function(){
        categoryId = $(this).data('id');
        activeTab = $(this).parents('.item').data('id');
        console.log('activeTab:'+activeTab+' tabs:'+tabs);

        updateTabs($(this).data('name'), 'fa-list-ul');

        $('#wgCarousel').find("#tab"+tabs).load( "/api/v1/widget/getServices",  {sid:sid, sc_id:categoryId, org_id:orgId},  function() {
            $('#content').removeClass('loadingbox');
            $('#wgCarousel').carousel(tabs);
        });
    });

    /**
     *   Выбрана услуга, подгружаем экран с исполнителями
     */
    $('#content').on('click', 'a.service-row', function(){
        serviceId = $(this).data('id');
        activeTab = $(this).parents('.item').data('id');
        console.log('activeTab:'+activeTab+' tabs:'+tabs);

        updateTabs($(this).data('name'), 'fa-arrow-circle-right');

        $('#wgCarousel').find("#tab"+tabs).load("/api/v1/widget/getEmployees",  {sid:sid, service_id:serviceId, org_id:orgId},  function() {
            $('#wgCarousel').carousel(tabs);
            $('#content').removeClass('loadingbox');
        });
    });

    /**
     *   Выбран исполнитель, подгружаем экран с днями
     */
    $('#content').on('click', 'a.employee-row', function(){
        employeeId = $(this).data('id');
        activeTab = $(this).parents('.item').data('id');

        updateTabs($(this).data('name'),'fa-user');

        $('#wgCarousel').find("#tab"+tabs).load( "/api/v1/widget/getAvailableDays",  {sid:sid, employee_id:employeeId, org_id:orgId, service_id:serviceId},  function() {
            $('#content').removeClass('loadingbox');
            $('#wgCarousel').carousel(tabs);
        });
    });

    /**
     * Выбран день, подгружаем экран с временными интервалами
     */
    $('#content').on('click', 'a.day-row', function(){
        date = $(this).data('id');
        activeTab = $(this).parents('.item').data('id');
        updateTabs($(this).data('name'),'fa-calendar');

        $('#wgCarousel').find("#tab"+tabs).load( "/api/v1/widget/getAvailableTime",  {sid:sid, date:date, employee_id:employeeId, org_id:orgId, service_id:serviceId},  function() {
            $('#content').removeClass('loadingbox');
            $('#wgCarousel').carousel(tabs);
        });
    });

    /**
     *   Выбран временной интервал, подгружаем экран с формой оформления
     */
    $('#content').on('click', 'a.time-row', function(){
        time = $(this).data('id');
        activeTab = $(this).parents('.item').data('id');
        updateTabs($(this).data('name'), 'fa-clock-o');

        $('#wgCarousel').find("#tab"+tabs).load( "/api/v1/widget/getUserInformationForm",  {sid:sid, time:time, date:date, employee_id:employeeId, org_id:orgId, service_id:serviceId},  function() {
            $('#content').removeClass('loadingbox');
            $('#wgCarousel').carousel(tabs);
        });
    });

    /**
     * Отправка формы онлайн-заказа
     */
    $('#content').on('click','#sendRequest', function(){
        // валидация
        var message = '';
        $( ".agree-box" ).removeClass('has-error');
        $( ".name-box" ).removeClass('has-error');
        $( ".phone-box" ).removeClass('has-error');
        $( ".form-message" ).hide().removeClass('bg-success').removeClass('bg-danger');


        if ($('#clientName').val() == '') {
            $( ".name-box" ).addClass('has-error');
            message = 'Please fill out required fields';
        }
        if ($('#clientPhone').val() == '') {
            $( ".phone-box" ).addClass('has-error');
            message = 'Please fill out required fields';
        }

        if ( ! $('#agree').is(":checked")) {
            $(".agree-box").addClass('has-error');
            message = 'Please fill out required fields';
        }
        if (message == ''){
            // отправка формы
            $('#content').addClass('loadingbox');
            $.ajax({
                type: "GET",
                url: "/api/v1/widget/handleUserInformationForm",
                dataType: "json",
                data: $('#requestForm').serialize(),
                success: function(result) {
                    $('#content').removeClass('loadingbox');
                    if( result.res ){
                        $( ".form-message" ).show().html('Заявка создана').addClass('bg-success');
                        $('#requestForm')[0].reset();
                    } else {
                        $( ".form-message" ).show().html('Ошибка').addClass('bg-danger');
                    }
                }
            });
        } else {
            //отображаем сообщение об ошибке
            $(".form-message").show().html(message).addClass('bg-danger');
            return false;
        }
    });


    /**
     * показ страницы с информацие об организации
     */
    $('body').on('click', 'a.info-link', function(){
        $( "#info-block" ).load( "/api/v1/widget/getOrgInformation",  {org_id:orgId},  function() {
            // $( "#info-block" ).show();
            $( "#info-block" ).fadeIn( "slow", function() {
                // Animation complete
            });
        });
    });
    $('body').on('click', 'a.close-info', function(){
        $( "#info-block" ).hide();
    });

});