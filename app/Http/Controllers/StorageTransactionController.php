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
use App\StorageTransaction;
use Session;
use Illuminate\Support\Facades\Input;

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

		// dd($transactions);     

		$partners = Partner::where('organization_id', $request->user()->organization_id)->pluck('title', 'partner_id');
		$accounts = Account::where('organization_id', $request->user()->organization_id)->pluck('title', 'account_id');
		$employees = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
		$clients = Client::where('organization_id', $request->user()->organization_id)->pluck('name', 'client_id');
		$user = $request->user();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($transactions, $offset, $paginate, true);
		$transactions = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($transactions), $paginate, $page);
		$transactions->setPath('payment');

		// return view('storageTransaction.index', ['user' => $request->user(), 'partners' => $partners, 'accounts' => $accounts, 'employees' => $employees, 'clients' => $clients])->withtransactions($transactions);
		return view('storageTransaction.index', compact('user', 'partners', 'accounts' , 'employees' , 'clients', 'transactions'));
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
		$transaction->client_id = 0;
		$transaction->employee_id = 0;
		$transaction->storage1_id = $request->storage_id;
		$transaction->storage2_id = 0;
		$transaction->partner_id = $request->partner_id;
		$transaction->account_id = 0;
		$transaction->description = $request->description;
		$transaction->is_paidfor = $request->ispaidfor == 1;
		$transaction->product_items = json_encode(array($input['product_id'], $input['price'], $input['amount'], $input['discount'], $input['sum'], $input['code']));
		$transaction->organization_id = $request->user()->organization_id;

		$transaction->save();

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

		$transaction_hours = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 60, '', ' ч', 'G');
		$transaction_minutes = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('00:59:00'), 1, '', ' мин', 'i');

		return view('storageTransaction.edit', compact('clients', 'employees', 'accounts', 'partners', 'storages', 'transaction', 'transaction_hours', 'transaction_minutes'));
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
		$transaction->client_id = 0;
		$transaction->employee_id = 0;
		$transaction->storage1_id = $request->storage_id;
		$transaction->storage2_id = 0;
		$transaction->partner_id = $request->partner_id;
		$transaction->account_id = 0;
		$transaction->description = $request->description;
		$transaction->is_paidfor = $request->ispaidfor == 1;
		$transaction->product_items = json_encode(array($input['product_id'], $input['price'], $input['amount'], $input['discount'], $input['sum'], $input['code']));
		$transaction->organization_id = $request->user()->organization_id;

		$transaction->save();

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
