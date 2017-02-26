/*! jwgSlider 2014-09-11 */
var JwgSlider=function(){var a=this;this.move=function(b){var c,d;if("number"!=typeof b)c="right"==b?this.index+=1:this.index-=1;else if(c=b,c>this.index+1||c<this.index-1)return void this.skipToSlide(c);c==this.slides.length||-1==c?(c=-1==c?this.slides.length-1:0,this.loopSlide(c)):(d="-"+100*c+"%",this.setIndex(c),this.x.stop(!0,!0).animate({left:d},this.speed,function(){a.left=d}))},this.skipToSlide=function(b){var c;b>this.index+1?(this.current.nextUntil(this.slides.eq(b)).css("display","none"),c="-"+100*(this.index+1)+"%",this.setIndex(b),this.x.stop(!0,!0).animate({left:c},this.speed,function(){c="-"+100*b+"%",a.x.css("left",c),a.slides.css("display","block")})):(this.current.prevUntil(this.slides.eq(b)).css("display","none"),c="-"+100*(b+1)+"%",this.x.css("left",c),c="-"+100*b+"%",this.setIndex(b),this.x.stop(!0,!0).animate({left:c},this.speed,function(){a.slides.css("display","block")}))},this.loopSlide=function(b){var c,d,e,f;b==this.slides.length-1?(d=100*b,e=100*(b-1),c=this.slides.eq(0),c.css("display","none").clone().appendTo(this.x).css("display","block"),f=a.x.find(".slide:last")):(d=0,e=100,c=this.slides.eq(this.slides.length-1),c.css("display","none").clone().prependTo(this.x).css("display","block"),f=a.x.find(".slide:first")),this.x.css({left:"-"+d+"%"}),this.setIndex(b),this.x.stop(!0,!0).animate({left:"-"+e+"%"},this.speed,function(){f.remove(),c.css("display","block"),a.x.css({left:"-"+d+"%"}),a.left=d})},this.setIndex=function(a){this.index=a,this.tabs.removeClass("current").eq(a).addClass("current"),this.slides.removeClass("current").eq(a).addClass("current"),this.current=this.slides.eq(a)},this.init=function(a,b,c){this.slider=a,this.type=b,this.x=this.slider.find(".slides"),this.slides=this.x.children(".slide"),this.arrows=this.slider.find(".arrow_navigation > div"),this.tabs=this.slider.find(".tabbed_navigation ul li"),this.index=0,this.speed=c,this.left="0%",this.current=this.slides.eq(0),this.setWidths(),this.addActions(),this.setCurrent()},this.setCurrent=function(){this.slides.eq(0).addClass("current"),this.tabs.eq(0).addClass("current")},this.addActions=function(){var b=this.slider.find(".arrow_navigation");("arrows"==this.type||"both"==this.type)&&this.arrows.click(function(){var b=$(this).attr("class");a.x.is(":animated")||a.move(b)}),("tabs"==this.type||"both"==this.type)&&this.tabs.click(function(){var b=$(this).index();a.x.is(":animated")||a.move(b)}),this.slider.on({mouseover:function(){b.addClass("on")},mouseleave:function(){b.removeClass("on")}})},this.setWidths=function(){var a=100/this.slides.length+"%",b=100*this.slides.length+"%";this.slides.css("width",a),this.x.css("width",b)}};$.fn.jwgSlider=function(a,b){return this.each(function(){var c=$(this);(new JwgSlider).init(c,a,b)})};
// set variables
var data;
var orgId = '';
var categoryId = '';
var serviceId = '';
var employeeId = '';
var date = '';
var time = '';

$(document).ready(function() {
    /**
     * первоначальная загрузка контента
     */
    $("#content").load( "/api/v1/widget/getDivisions",  function() {
//            console.log( "Load was performed." );
    });

    /**
     *  Выбрана организация, получаем экран с категориями
     */
    $('#content').on('click', 'a.division-row', function(){
        orgId = $(this).data('id');
        $( ".breadcrumbs" ).append( "<div>"+$(this).data('name')+"</div>" );
        $( ".address" ).append( "<div>" + $(this).data('address') + '<br>' + $(this).data('phone') + "</div>" );

        $( "#content" ).load( "/api/v1/widget/getCategories",  { org_id:orgId },  function() {
            //console.log( "Load was performed." );
        });
    });

    /**
     *  Выбрана категория, подгружаем экран с услугами
     */
    $('#content').on('click', 'a.category-row', function(){
        categoryId = $(this).data('id');
        $( ".breadcrumbs" ).append( "<div>"+$(this).data('name')+"</div>" );

        $( "#content" ).load( "/api/v1/widget/getServices",  {sc_id:categoryId, org_id:orgId},  function() {
            console.log( "Load was performed." );
        });
    });
    /**
     *  2 выбор услуги
     */
    $('#content').on('click', 'a.service-row', function(){
        serviceId = $(this).data('id');
        console.log('Выбрана услуга' + serviceId);
        $( ".breadcrumbs" ).append( "<div>"+$(this).data('name')+"</div>" );
        $( "#content" ).load( "/api/v1/widget/getEmployees",  {service_id:serviceId, org_id:orgId},  function() {
            console.log( "Load was performed." );
        });
    });
    /**
     *  2 выбор услуги
     */
    $('#content').on('click', 'a.employee-row', function(){
        employeeId = $(this).data('id');
        console.log('Выбран исполнитель' + serviceId);
        $( ".breadcrumbs" ).append( "<div>"+$(this).data('name')+"</div>" );
        $( "#content" ).load( "/api/v1/widget/getAvailableDays",  {employee_id:employeeId, org_id:orgId, service_id:serviceId},  function() {
            console.log( "Load was performed." );
        });
    });
    /**
     *  2 выбор услуги
     */
    $('#content').on('click', 'a.day-row', function(){
        date = $(this).data('id');
        console.log('Выбран день' + date);
        $( ".breadcrumbs" ).append( "<div>"+$(this).data('name')+"</div>" );
        $( "#content" ).load( "/api/v1/widget/getAvailableTime",  {date:date, employee_id:employeeId, org_id:orgId, service_id:serviceId},  function() {
            console.log( "Load was performed." );
        });
    });
    $('#content').on('click', 'a.time-row', function(){
        time = $(this).data('id');
        console.log('Выбрано время' + time);
        $( ".breadcrumbs" ).append( "<div>"+$(this).data('name')+"</div>" );
        $( "#content" ).load( "/api/v1/widget/getUserInformationForm",  {time:time, date:date, employee_id:employeeId, org_id:orgId, service_id:serviceId},  function() {
            console.log( "Load was performed." );
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
                //$(this).parents('.product-container').removeClass('loading');
                console.log(res);
                if(result.res){

                } else {
                    alert('ошибка');
                }
            }
        });
    });
    $('body').on('click', 'a.info-link', function(){
        console.log('clicken');
        $( "#info-block" ).load( "/api/v1/widget/getOrgInformation",  {org_id:orgId},  function() {
            console.log( "Load was performed." );
        });
    });
});
//# sourceMappingURL=widget.js.map
