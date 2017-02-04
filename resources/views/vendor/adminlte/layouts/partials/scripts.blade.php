<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>

<script src="{{ asset('/js/jqgrid/i18n/grid.locale-ru.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jqgrid/jquery.jqGrid.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/jQueryUI/jquery-ui.min.js') }}" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/vue/1.0.28/vue.js"></script>
<script src="{{ asset('/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}"></script>

{{-- <script src="//api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU&mode=debug" type="text/javascript"></script> --}}
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
]); ?>
</script>
