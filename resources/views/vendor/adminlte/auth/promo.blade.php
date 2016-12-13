<!-- Terms and conditions modal -->
<div class="modal fade" id="promoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Мой промо-код</h4>
      </div>
      <div class="modal-body">
        <div class="form-group has-feedback">
			<input type="text" class="form-control" placeholder="{{ trans('adminlte_lang::message.promo') }}" name="promo" value="{{ old('promo') }}"/>
			{{-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> --}}
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Подтвердить</button>
      </div>
    </div>
  </div>
</div>