<script type="text/javascript">
    $(document).ready(function($) {
        $('#card-items .wrap-it select.form-control').select2({
            theme: "alt-control",
            minimumResultsForSearch: Infinity
        }).on("select2:open", function () {
            $('.select2-results__options').niceScroll({cursorcolor:"#969696", cursorborder: "1px solid #787878", cursorborderradius: "0", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.9, cursoropacitymax:1, boxzoom:true, autohidemode:false});
        });

        // getting the list of products when choose storage
        $('#card-items').on('change', 'select[name="storage_id[]"]', function(e){
            $(this).find('[value=null]').remove();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'storage_id' : $(this).val()},
                url: "<?php echo route('card.productOptions') ?>",
                success: function(data) {
                    $(e.target).parent().next().children('select[name="product_id[]"]').first().html('');
                    $(e.target).parent().next().children('select[name="product_id[]"]').first().html(data.options);
                }
            });
        });
    });
</script>