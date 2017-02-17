<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta id="_token" value="{{ csrf_token() }}">
    @if ($locale == 'ru')
        <title>INFOGROUP.ONLINE Мощная и интуитивная платформа автоматизации сферы услуг!</title>
    @else
        <title>Programa de la inscripcion de clientes en linea. Inscripcion en linea en el sitio  | INFOGROUP.ONLINE</title>
        <meta name="description" content="INFOGROUP.ONLINE es un programa de inscripcion de clientes en linea. Funciona 24/7, utiliza su diseno, esta integrado con las redes sociales. Probar gratis">
        <meta name="keywords" content="programa de la inscripcion de clientes en linea,inscripcion en linea en el sitio,infogroup online,auromatizacion en el sector de servicios,estadisticas y analisis en el sector de servicios,censura de cuentas en el sector de servicios,aplicaciones moviles de inscripcion de clientes en linea">
        <meta property="og:title" content="INFOGROUP.ONLINE es un widget de inscripcion en linea para un sitio web y redes sociales"/>
        <meta property="og:description" content="Inscripcion en linea permite no perder nuevos clientes"/>
    @endif
    <meta name="author" content="INFOGROUP.ONLINE">
    <meta property="og:image" content="/img/landing/logo.jpg"/>
    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://infogroup.online"/>
    <link type="/img/landing/png" href="/img/favicon.png" rel="shortcut icon">


    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet" type="text/css">

    <!-- project scripts -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/landing.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrapper">
    @include($sidepanel, ['page' => $page])
    <div class="w1">
        <header id="header">
            <a href="/" class="logo"><img src="/img/landing/logo.svg"></a>
        </header>
        @include($content)
    </div>
</div>
<div id="toTop"></div>

<!--<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>-->

<script src="{{ asset('/js/jqgrid/i18n/grid.locale-ru.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jqgrid/jquery.jqGrid.min.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/vue/1.0.28/vue.js"></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-52416223-3', 'auto');
    ga('send', 'pageview');
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter42486754 = new Ya.Metrika({
                    id:42486754,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/42486754" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
</body>
</html>