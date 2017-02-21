<html>
<body>
<!--<div id="app">-->
<!--    <widget></widget>-->
<!--    <widget></widget>-->
<!--</div>-->
<!--<template id="widget-template">-->
<!--    <h1>waka</h1>-->
<!--</template>-->

<h1>Organization</h1>
<div> {{ $organization->organization_id }} </div>
<div> {{ $organization->name }} </div>
<div> {{ $organization->category }} </div>
<div> {{ $organization->shortinfo }} </div>
<div> <img src="{{$organization->getLogoUri()}}"> </div>
<hr>


<h1>Categories</h1>
@foreach ($serviceCategories as $sc)
<p>Категория: {{ $sc->online_reservation_name}}</p>
<span> {{ $sc->service_category_id}} </span>|
<span> {{ $sc->gender}} </span>|
<span> {{ $sc->name}} </span>
<hr>
@endforeach




<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.27/vue.js"></script>
<!--<script src="/js/widget.js"></script>-->
</body>
</html>