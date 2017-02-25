<h1>Оформление</h1>
<h3>Онлайн запись</h3>

<form onsubmit="return false;" id ='requestForm'>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
    </div>
    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea name="comment" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="remind">Remind me</label>
        <select name="remind" id="remind" class="form-control">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
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


