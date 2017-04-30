<div class="row">
    <div class="col-sm-5">
        <h4>New call</h4>
        <div class="form-group">
            <input type="hidden" class="form-control"id="app_call_id" value="">
            <input type="hidden" class="form-control"id="app_call_appointment_id" value="">
            <input type="text" class="form-control" placeholder="Title" id="app_call_title">
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                <input type="text" class="form-control" name="birthday" id="app_call_date" placeholder="@lang('main.client:birthday_label')">
            </div>
        </div>
        <div class="form-group">
            <textarea class="form-control" rows="5" id="app_call_description" placeholder="Description"></textarea>
        </div>
        <div class=" text-right m-t">
            <button type="button" id='save_call_info' class="btn btn-info">Save call info</button>
        </div>
    </div>
    <div class="col-sm-7" id="app_calls_history">

    </div>

</div>