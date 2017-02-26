<h1>{{ $organization->name }}</h1>
<h4>{{ $organization->category }}</h4>
<h4>{{ $organization->logo_image }}</h4>

<h3>Контакты</h3>
<div class="row">
    <div class="col-sm-4">Телефон</div>
    <div class="col-sm-8">{{ $organization->phone_1 }}</div>
</div>
<div class="row">
    <div class="col-sm-4">Телефон</div>
    <div class="col-sm-8">{{ $organization->phone_2 }}</div>
</div>
<div class="row">
    <div class="col-sm-4">Телефон</div>
    <div class="col-sm-8">{{ $organization->phone_3 }}</div>
</div>
<div class="row">
    <div class="col-sm-4">Адрес</div>
    <div class="col-sm-8">{{ $organization->address }}</div>
</div>
<div class="row">
    <div class="col-sm-4">Часы работы</div>
    <div class="col-sm-8">{{ $organization->work_hours }}</div>
</div>
<div class="row">
    <div class="col-sm-4">Информация</div>
    <div class="col-sm-8">{{ $organization->shortinfo }}</div>
</div>