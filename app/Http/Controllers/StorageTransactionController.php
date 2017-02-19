<?php

namespace App\Http\Controllers;

use App\StorageTransaction;
use Illuminate\Http\Request;

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
							->with('account', 'partner', 'client', 'employee')
							->get()->all();

		dd($transactions);     

		$items = Item::where('organization_id', $request->user()->organization_id)->pluck('title', 'item_id');
		$partners = Partner::where('organization_id', $request->user()->organization_id)->pluck('title', 'partner_id');
		$accounts = Account::where('organization_id', $request->user()->organization_id)->pluck('title', 'account_id');
		$employees = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
		$clients = Client::where('organization_id', $request->user()->organization_id)->pluck('name', 'client_id');

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($payments, $offset, $paginate, true);
		$payments = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($payments), $paginate, $page);
		$payments->setPath('payment');


		return view('payment.index', ['user' => $request->user(), 'items' => $items, 'partners' => $partners, 'accounts' => $accounts, 'employees' => $employees, 'clients' => $clients])->withpayments($payments);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
