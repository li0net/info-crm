
<div id="copyright text-center">INfogroup</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    var orgId = '';
    $(document).ready(function() {
        /**
         *  1 выбор организации
         */
        $( ".division-row" ).click(function() {
            orgId = $(this).data('id');
            console.log('Выбрана организация' + orgId);

            $( "#content" ).load( "/api/v1/widget/getCategories",  {org_id:orgId, location: "Boston"},  function() {
                console.log( "Load was performed." );
            });
//            $.ajax({
//                type: "GET",
//                url: "/api/v1/widget/categories",
//                dataType: "json",
//                data: { org_id: orgId, location: "Boston" },
//                success: function(result) {
//                    //$(this).parents('.product-container').removeClass('loading');
//                    //console.log(res);
//                    if(result.res){
//
//                    } else {
//                        alert('ошибка')ж
//                    }
//                }
//            });
        });
        /**
         *  1 выбор категории
         */
//        $( ".category-row" ).on( "click", "a.offsite", function() {
        $('#content').on('click', 'a.category-row', function(){
//        $( ".category-row" ).click(function() {
            var categoryId = $(this).data('id');
            console.log('Выбрана категория' + categoryId);
//
            $( "#content" ).load( "/api/v1/widget/getServicesAjax",  {sc_id:categoryId, org_id:orgId},  function() {
                console.log( "Load was performed." );
            });
//            $.ajax({
//                type: "GET",
//                url: "/api/v1/widget/categories",
//                dataType: "json",
//                data: { org_id: orgId, location: "Boston" },
//                success: function(result) {
//                    //$(this).parents('.product-container').removeClass('loading');
//                    //console.log(res);
//                    if(result.res){
//
//                    } else {
//                        alert('ошибка')ж
//                    }
//                }
//            });
        });



    });
</script>