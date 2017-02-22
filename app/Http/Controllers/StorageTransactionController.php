<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;

use App\Client;
use App\Account;
use App\Payment;
use App\Partner;
use App\Employee;
use App\Storage;
use App\Product;
use App\StorageTransaction;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class StorageTransactionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$transactions = StorageTransaction::where('organization_id', $request->user()->organization_id)
							->with('account', 'partner', 'client', 'employee', 'storage1')
							->get()->all();

		$partners = Partner::where('organization_id', $request->user()->organization_id)->pluck('title', 'partner_id');
		$accounts = Account::where('organization_id', $request->user()->organization_id)->pluck('title', 'account_id');
		$employees = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
		$clients = Client::where('organization_id', $request->user()->organization_id)->pluck('name', 'client_id');
		$storages = Storage::where('organization_id', $request->user()->organization_id)->pluck('title', 'storage_id');
		$user = $request->user();

		$filtered = Input::get('index');

		$page = Input::get('page', 1);
		$paginate = 10;

		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($transactions, $offset, $paginate, true);
		$transactions = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($transactions), $paginate, $page);
		$transactions->setPath('storagetransaction');

		return view('storageTransaction.index', compact('user', 'partners', 'accounts' , 'employees' , 'clients', 'storages', 'transactions'));
	}

	public function indexFiltered(Request $request)
	{
		$transactions = storageTransaction::where('organization_id', $request->organization_id);

		if('0' !== $request->transaction_type) {
			$transactions = $transactions->where('type', $request->transaction_type);
		}

		if('' !== $request->account_id) {
			$transactions = $transactions->where('account_id', $request->account_id);
		}

		if('' !== $request->storage_id) {
			$transactions->where('storage1_id', $request->storage_id);
		}

		if('' !== $request->employee_id) {
			$transactions->where('employee_id', $request->employee_id);
		}

		if('' !== $request->partner_id) {
			$transactions->where('partner_id', $request->partner_id);
		}

		if('' !== $request->client_id) {
			$transactions->where('client_id', $request->client_id);
		}
		
		$filter_start_time = date_create($request->date_from.'00:00:00');
		date_format($filter_start_time, 'U = Y-m-d 0:0:0');

		$filter_end_time = date_create($request->date_to.'23:59:59');
		date_format($filter_end_time, 'U = Y-m-d 23:59:59');

		$transactions->whereBetween('date', [$filter_start_time, $filter_end_time]);

		$transactions = $transactions->with('account', 'storage1', 'partner', 'client', 'employee')->get();

		$page = (0 == $request->page) ? 1 : $request->page;
		$paginate = 10;

		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = $transactions->slice($offset, $paginate);

		$transactions = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($transactions), $paginate, $page);
		$transactions->setPath('\storagetransaction');
		$transactions->appends(['index' => 'filtered']);

		return View::make('storageTransaction.list', compact('transactions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$partners = Partner::where('organization_id', $request->user()->organization_id)->pluck('title', 'partner_id');
		$accounts = Account::where('organization_id', $request->user()->organization_id)->pluck('title', 'account_id');
		$employees = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
		$clients = Client::where('organization_id', $request->user()->organization_id)->pluck('name', 'client_id');
		$storages = Storage::where('organization_id', $request->user()->organization_id)->pluck('title', 'storage_id');

		$transaction_hours = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 60, '', ' ч', 'G');
		$transaction_minutes = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('00:59:00'), 1, '', ' мин', 'i');

		return view('storageTransaction.create', compact('clients', 'employees', 'accounts', 'partners', 'storages', 'transaction_hours', 'transaction_minutes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$accessLevel = $request->user()->hasAccessTo('storageTransaction', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, []);

		$input = $request->input();

		array_shift($input['product_id']);
		array_shift($input['price']);
		array_shift($input['amount']);
		array_shift($input['discount']);
		array_shift($input['sum']);
		array_shift($input['code']);

		$transaction = new storageTransaction;

		$transaction->date = date_create($request->input('transaction-date').$request->input('transaction-hour').':'.$request->input('transaction-minute'));
		date_format($transaction->date, 'U = Y-m-d H:i:s');

		$transaction->type = $request->type;
		if ($request->type == 'income') {
			$transaction->client_id = 0;
			$transaction->employee_id = 0;
			$transaction->storage1_id = $request->storage_id;
			$transaction->storage2_id = 0;
			$transaction->partner_id = $request->partner_id;
			$transaction->account_id = 0;
		} elseif ($request->type == 'expenses') {
			$transaction->client_id = $request->client_id;
			$transaction->employee_id = $request->employee_id;
			$transaction->storage1_id = $request->storage_id;
			$transaction->storage2_id = 0;
			$transaction->partner_id = 0;
			$transaction->account_id = 0;
		} elseif ($request->type == 'discharge'){
			$transaction->client_id = 0;
			$transaction->employee_id = 0;
			$transaction->storage1_id = $request->storage_id;
			$transaction->storage2_id = 0;
			$transaction->partner_id = 0;
			$transaction->account_id = 0;
		} else {
			$transaction->client_id = 0;
			$transaction->employee_id = 0;
			$transaction->storage1_id = $request->storage_id;
			$transaction->storage2_id = $request->storage2_id;
			$transaction->partner_id = 0;
			$transaction->account_id = 0;
		}
		
		$transaction->description = $request->description;
		$transaction->is_paidfor = $request->ispaidfor == 1;
		$transaction->transaction_items = json_encode(array($input['product_id'], $input['price'], $input['amount'], $input['discount'], $input['sum'], $input['code']));
		$transaction->organization_id = $request->user()->organization_id;

		$transaction->save();

		foreach ($input['product_id'] as $key => $value) {
			$product = Product::where('organization_id', $request->user()->organization_id)->where('product_id', $value)->first();
			
			if ($request->type == 'income') {
				$product->amount += $input['amount'][$key];
			} elseif ($request->type == 'expenses') {
				$product->amount -= $input['amount'][$key];	
			} elseif ($request->type == 'discharge'){
				$product->amount -= $input['amount'][$key];
			} else {
				$product->storage_id = $request->storage2_id;
			}

			$product->save();
		}

		Session::flash('success', 'Новая операция успешно проведена!');

		return redirect()->route('storagetransaction.show', $transaction->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		$transaction = storageTransaction::find($id);

		return view('storageTransaction.show', compact('transaction'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$transaction = storageTransaction::find($id);

		$partners = Partner::where('organization_id', $request->user()->organization_id)->pluck('title', 'partner_id');
		$accounts = Account::where('organization_id', $request->user()->organization_id)->pluck('title', 'account_id');
		$employees = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
		$clients = Client::where('organization_id', $request->user()->organization_id)->pluck('name', 'client_id');
		$storages = Storage::where('organization_id', $request->user()->organization_id)->pluck('title', 'storage_id');
		$pr = Product::with('storageWithProducts')->get()->pluck('storageWithProducts', 'product_id');
		
		$transaction_hours = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 60, '', ' ч', 'G');
		$transaction_minutes = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('00:59:00'), 1, '', ' мин', 'i');

		$transaction_items = array();
		
		if(null !== $transaction->transaction_items) {
			$items = json_decode($transaction->transaction_items);
			
			foreach ($items[0] as $key => $value) {
				$transaction_items[] = array($value, $items[1][$key], $items[2][$key], $items[3][$key], $items[4][$key], $items[5][$key]);
			}
		}

		Session::flash('jopa', $transaction_items);

		return view('storageTransaction.edit', compact('clients', 'employees', 'accounts', 'partners', 'storages', 'transaction', 'transaction_hours', 'transaction_minutes', 'transaction_items', 'pr'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$accessLevel = $request->user()->hasAccessTo('storageTransaction', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, []);

		$input = $request->input();

		array_shift($input['product_id']);
		array_shift($input['price']);
		array_shift($input['amount']);
		array_shift($input['discount']);
		array_shift($input['sum']);
		array_shift($input['code']);

		$transaction = storageTransaction::where('organization_id', $request->user()->organization_id)->where('id', $id)->first();
		if (is_null($transaction)) {
			return 'No such transaction';
		}

		$transaction->date = date_create($request->input('transaction-date').$request->input('transaction-hour').':'.$request->input('transaction-minute'));
		date_format($transaction->date, 'U = Y-m-d H:i:s');

		$transaction->type = $request->type;
		if ($request->type == 'income') {
			$transaction->client_id = 0;
			$transaction->employee_id = 0;
			$transaction->storage1_id = $request->storage_id;
			$transaction->storage2_id = 0;
			$transaction->partner_id = $request->partner_id;
			$transaction->account_id = 0;
		} elseif ($request->type == 'expenses') {
			$transaction->client_id = $request->client_id;
			$transaction->employee_id = $request->employee_id;
			$transaction->storage1_id = $request->storage_id;
			$transaction->storage2_id = 0;
			$transaction->partner_id = 0;
			$transaction->account_id = 0;
		} elseif ($request->type == 'discharge'){
			$transaction->client_id = 0;
			$transaction->employee_id = 0;
			$transaction->storage1_id = $request->storage_id;
			$transaction->storage2_id = 0;
			$transaction->partner_id = 0;
			$transaction->account_id = 0;
		} else {
			$transaction->client_id = 0;
			$transaction->employee_id = 0;
			$transaction->storage1_id = $request->storage_id;
			$transaction->storage2_id = $request->storage2_id;
			$transaction->partner_id = 0;
			$transaction->account_id = 0;
		}
		$transaction->description = $request->description;
		$transaction->is_paidfor = $request->is_paidfor == true;
		$transaction->transaction_items = json_encode(array($input['product_id'], $input['price'], $input['amount'], $input['discount'], $input['sum'], $input['code']));
		$transaction->organization_id = $request->user()->organization_id;

		$transaction->save();

		dd(Session::get('jopa'));

		Session::flash('success', 'Информация об операции успешно обновлена!');

		return redirect()->route('storagetransaction.show', $transaction->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$transaction = storageTransaction::where('organization_id', $request->user()->organization_id)->where('id', $id)->first();

		if ($transaction) {
			$transaction->delete();
			Session::flash('success', 'Операция была успешно удалена!');
		} else {
			Session::flash('error', 'Операция не найдена!');
		}

		return redirect()->route('storagetransaction.index');
	}

	protected function populateTimeIntervals($startTime, $endTime, $interval, $modifier_before, $modifier_after, $time_format) {
		$timeIntervals = [];
		
		while ($startTime <= $endTime) {
			$timeStr = date($time_format, $startTime);
			$timeIntervals[$timeStr] = $modifier_before.$timeStr.$modifier_after;

			$startTime += 60*$interval; 
		}
		
		return $timeIntervals;
	}
}
