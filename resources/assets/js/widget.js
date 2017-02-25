//TODO ПЕРЕПИСАТЬ НА VUE

// set variables
var data;
var orgId = '';
var categoryId = '';
var serviceId = '';
var employeeId = '';
var date = '';
var time = '';
var tabs = 0;
var activeTab = 0;

$(document).ready(function() {
    /** первоначальная загрузка контента */
    $("#tab0").load( "/api/v1/widget/getDivisions",  function() {
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
    function updateTabs(tabName) {
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
        $('#wgCarousel').find('#crumb'+tabs+' a').html(tabName);
        $('#wgCarousel').find('#crumb'+tabs).removeClass('hidden');

        // инкремент количества табов
        tabs++;

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

        updateTabs($(this).data('name'));

        $(".address").html( "<div>" + $(this).data('address') + '<br>' + $(this).data('phone') + "</div>" );
        $('#wgCarousel').find("#tab"+tabs).load( "/api/v1/widget/getCategories",  { org_id:orgId },  function() {
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

        updateTabs($(this).data('name'));

        $('#wgCarousel').find("#tab"+tabs).load( "/api/v1/widget/getServices",  {sc_id:categoryId, org_id:orgId},  function() {
            $('#content').removeClass('loadingbox');
            $('#wgCarousel').carousel(tabs);
        });
    });
    /**
     *  2 выбор услуги
     */
    $('#content').on('click', 'a.service-row', function(){
        serviceId = $(this).data('id');
        activeTab = $(this).parents('.item').data('id');
        console.log('activeTab:'+activeTab+' tabs:'+tabs);

        updateTabs($(this).data('name'));

        $('#wgCarousel').find("#tab"+tabs).load("/api/v1/widget/getEmployees",  {service_id:serviceId, org_id:orgId},  function() {
            $('#wgCarousel').carousel(tabs);
            $('#content').removeClass('loadingbox');
        });
    });
    /**
     *  2 выбор исполнителя
     */
    $('#content').on('click', 'a.employee-row', function(){
        employeeId = $(this).data('id');
        activeTab = $(this).parents('.item').data('id');

        updateTabs($(this).data('name'));

        $('#wgCarousel').find("#tab"+tabs).load( "/api/v1/widget/getAvailableDays",  {employee_id:employeeId, org_id:orgId, service_id:serviceId},  function() {
            $('#content').removeClass('loadingbox');
            $('#wgCarousel').carousel(tabs);
        });
    });
    /**
     *  2 выбор услуги
     */
    $('#content').on('click', 'a.day-row', function(){
        date = $(this).data('id');
        activeTab = $(this).parents('.item').data('id');
        updateTabs($(this).data('name'));

        $('#wgCarousel').find("#tab"+tabs).load( "/api/v1/widget/getAvailableTime",  {date:date, employee_id:employeeId, org_id:orgId, service_id:serviceId},  function() {
            $('#content').removeClass('loadingbox');
            $('#wgCarousel').carousel(tabs);
        });
    });
    $('#content').on('click', 'a.time-row', function(){
        time = $(this).data('id');
        activeTab = $(this).parents('.item').data('id');
        updateTabs($(this).data('name'));

        $('#wgCarousel').find("#tab"+tabs).load( "/api/v1/widget/getUserInformationForm",  {time:time, date:date, employee_id:employeeId, org_id:orgId, service_id:serviceId},  function() {
            $('#content').removeClass('loadingbox');
            $('#wgCarousel').carousel(tabs);
        });
    });
    $('#content').on('click','#sendRequest', function(){
        console.log('click');
        //TODO валаидация
        $.ajax({
            type: "GET",
            url: "/api/v1/widget/handleUserInformationForm",
            dataType: "json",
            data: { org_id: orgId, location: "Boston" },
            data: $('#requestForm').serialize(),
            success: function(result) {
                //$(this).parents('.product-container').removeClass('loadingbox');
                console.log(res);
                if(result.res){
                    alert('заявка создана');
                } else {
                    alert('ошибка');
                }
            }
        });
    });
    $('body').on('click', 'a.info-link', function(){
        console.log('clicken');
        $( "#info-block" ).load( "/api/v1/widget/getOrgInformation",  {org_id:orgId},  function() {
            $('#content').removeClass('loadingbox');
        });
    });
});