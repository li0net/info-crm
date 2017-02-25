<!doctype html>
<html>
<head>
    @include('widget.includes.head')
</head>
<body>
    <div class="container">
        <header class="row">
            @include('widget.includes.header')
        </header>

        <div id="main" class="row">
            <div id="content" class="col-md-12 loadingbox">
                <div class="container">
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

        <footer class="row">
            @include('widget.includes.footer')
        </footer>
    </div>
</body>
</html>