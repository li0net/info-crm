@if(count($transactions) == 0)
	<div class="row">
		<hr>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			<h4><b>Операций с такими параметрами не обнаружено</b></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center m-b">
			Вы можете добавить новую операцию
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			<a href="/storagetransaction/create" class="btn btn-primary">Новая операция</a>
		</div>
	</div>
@else
	<table class="table table-hover table-striped">
		<thead>
			<th class="text-center">#</th>
			<th>Дата</th>
			<th>Наименование контрагента</th>
			<th>Тип операции</th>
			<th>Склад</th>
			<th>Комментарий</th>
			<th>Товар</th>
			<th>Количество</th>
			<th>Себестоимость</th>
			<th>Остаток на складе</th>
			<th>Визит</th>
		</thead>
		<tbody>
			@foreach($transactions as $transaction)
				<tr>
					<th class="text-center">{{ $transaction->id }}</th>
					<td>{{ $transaction->date }}</td>
					@if($transaction->type == 'income' && null !== $transaction->partner)
						<td>{{ $transaction->partner->title }}</td>
					@elseif($transaction->type == 'expenses' && null !== $transaction->client) 
						<td>{{ $transaction->client->name }}</td>
					@elseif($transaction->type == 'discharge')
						<td class='text-center'>-</td>
					@else
						<td class='text-center'>-</td>
					@endif
					{{-- <td>{{ $transaction->partner->title }}</td> --}}
					
					@if($transaction->type == 'income')
						<td>Приход</td>
					@elseif($transaction->type == 'expenses') 
						<td>Расход</td>
					@elseif($transaction->type == 'discharge')
						<td>Списание</td>
					@else
						<td>Перемещение</td>
					@endif

					<td>{{ $transaction->storage1->title }}</td>
					{{-- <td>{{ $transaction->account->title }}</td> --}}
					<td>{{ $transaction->description }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>

					<td class="text-right">
						@if ($user->hasAccessTo('storateTransaction', 'edit', 0))
							<a href="{{ route('storagetransaction.edit', $transaction->id) }}" id="transaction_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
						@endif
						@if ($user->hasAccessTo('storageTransaction', 'delete', 0))
							{!! Form::open(['route' => ['storagetransaction.destroy', $transaction->id], 'id' => 'form'.$transaction->id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
								<a href="javascript: submitform('#form{{$transaction->id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
							{!! Form::close() !!}
						@endif
					</td>	
				</tr>
			@endforeach
		</tbody>
	</table>
	<div class="text-center filtered">
		{!! $transactions->render(); !!} 
	</div>
@endif