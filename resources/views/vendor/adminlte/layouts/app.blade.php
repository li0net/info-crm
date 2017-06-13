<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

	@section('htmlheader')
		@include('adminlte::layouts.partials.htmlheader')
	@show

	<!--
	BODY TAG OPTIONS:
	=================
	Apply one or more of the following classes to get the
	desired effect
	|---------------------------------------------------------|
	| SKINS         | skin-blue                               |
	|               | skin-black                              |
	|               | skin-purple                             |
	|               | skin-yellow                             |
	|               | skin-red                                |
	|               | skin-green                              |
	|---------------------------------------------------------|
	|LAYOUT OPTIONS | fixed                                   |
	|               | layout-boxed                            |
	|               | layout-top-nav                          |
	|               | sidebar-collapse                        |
	|               | sidebar-mini                            |
	|---------------------------------------------------------|
	-->
<!--	<body class="skin-blue sidebar-mini">-->
	<body class="skin-orange sidebar-mini">
		<div id="app">
			<div class="wrapper">

				@include('adminlte::layouts.partials.mainheader')

				@include('adminlte::layouts.partials.sidebar')

				<!-- Content Wrapper. Contains page content -->
				<div class="content-wrapper">

					@include('adminlte::layouts.partials.contentheader')

					<!-- Main content -->
					<section class="content">
						<!-- Your Page Content Here -->
						@yield('main-content')
					</section><!-- /.content -->
				</div><!-- /.content-wrapper -->

				@include('adminlte::layouts.partials.controlsidebar')

				@include('adminlte::layouts.partials.modals')
				@include('adminlte::layouts.partials.locales')
				@include('adminlte::layouts.partials.footer')

			</div><!-- ./wrapper -->
		</div>

		@section('scripts')
			@include('adminlte::layouts.partials.scripts')
		@show

		@yield('page-specific-scripts')

		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter44818315 = new Ya.Metrika({
                            id:‎44818315,
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
		<noscript><div><img src="https://mc.yandex.ru/watch/44818315" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->

		<script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-‎100396483-2', 'auto');
            ga('send', 'pageview');

		</script>
	</body>
</html>
