<!doctype html>
<html>
<head>
    @include('widget.includes.head')
</head>
<body>
    <div class="container-fluid">
        <header class="row">
            @include('widget.includes.header')
        </header>
        <div id="main" class="row">
            <div id="content" class="col-md-12 loadingbox">
                <div id="wgCarousel" class="carousel slide" data-ride="carousel">
                    <ul class="nav">
                        <li data-target="#wgCarousel" data-slide-to="0" id='crumb0' class="active hidden"><a href="#"></a></li>
                    </ul>
                    <div class="carousel-inner">
                        <div class="item active" id="tab0" data-id="0" >
                            loading ...
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="info-block"></div>

        <footer>
            @include('widget.includes.footer')
        </footer>
    </div>

    @include('widget.includes.bottom_scripts')
    @include('widget.includes.modals')
</body>
</html>