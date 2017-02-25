<div id="info-block" class="info-block"></div>
<div id="address" class="address text-center"></div>
<hr>
<div id="copyright" class="text-center">INfogroup</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
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
</script>