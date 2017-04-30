<div class="row">
    <div class="col-sm-12">
        <p><b>@lang('main.appointment:client_num_visits'):&nbsp;</b>{{$clientData->num_visits}}</p>
        <p><b>@lang('main.appointment:client_last_visit_date'):&nbsp;</b>{{date('Y.m.d H:i', strtotime($clientData->last_visit))}}</p>
    </div>
</div>