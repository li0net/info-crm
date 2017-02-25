<h1>Оформление</h1>
<h3>Онлайн запись</h3>

<form onsubmit="return false;" id ='requestForm'>
    <input type="hidden" name="time" value="{{ $data['time'] }}">
    <input type="hidden" name="date" value="{{ $data['date'] }}">
    <input type="hidden" name="employeeId" value="{{ $data['employeeId'] }}">
    <input type="hidden" name="organizationId" value="{{ $data['organizationId'] }}">
    <input type="hidden" name="serviceId" value="{{ $data['serviceId'] }}">

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="clientName" name="client[name]" placeholder="Name">
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" class="form-control" id="clientPhone" name="client[phone]" placeholder="Phone">
    </div>
    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea name="client[comment]" id="clientComment" class="form-control" rows="3"></textarea>
    </div>

    <div class="form-group">
        <label for="remind">Remind me</label>
        <select name="client[remind]" id="clientRemind" class="form-control">
            <option value="1 hour">1 hour</option>
            <option value="2 hours">2 hours</option>
            <option value="1 day">1 day</option>
        </select>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    <input type="checkbox"  id="agree" name="agree" > Нажимая кнопку "Записаться", Вы соглашаетесь с <a href="#">условиями пользовательского соглашения</a>
                </label>
            </div>
        </div>
    </div>
    <button id="sendRequest" type="button" class="btn btn-default">Записаться</button>
</form>


