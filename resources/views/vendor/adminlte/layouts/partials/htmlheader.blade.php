<head>
    <meta charset="UTF-8">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <title> BarcelonaInfo - @yield('htmlheader_title', 'Your title here') </title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta id="_token" value="{{ csrf_token() }}">

    <meta name="author" content="INFOGROUP.ONLINE">
    <meta property="og:image" content="/img/crm/logo.jpg"/>
    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://infogroup.online"/>
    <link type="/img/crm/png" href="/img/favicon.png" rel="shortcut icon">

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/ui.jqgrid-bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/iCheck/flat/purple.css') }}" rel="stylesheet" type="text/css" />
    <!--link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" type="text/css"/-->
    <link href="https://almsaeedstudio.com/themes/AdminLTE/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/general.css') }}" rel="stylesheet" type="text/css" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!--Dynamic StyleSheets added from a view would be pasted here-->
    @stack('styles')

    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
