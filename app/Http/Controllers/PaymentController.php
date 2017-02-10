<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\User;
use App\Account;
use App\Payment;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PaymentController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$payments = Payment::where('organization_id', $request->user()->organization_id)->with('account', 'item', 'user')->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($payments, $offset, $paginate, true);
		$payments = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($payments), $paginate, $page);
		$payments->setPath('payment');

		// foreach ($payments as &$payment) {
		// 	$item = Item::where('organization_id', $request->user()->organization_id)->where('item_id', $payment->item_id)->get()->first();
		// 	$account = Account::where('organization_id', $request->user()->organization_id)->where('account_id', $payment->account_id)->get()->first();
		// 	$author = User::where('organization_id', $request->user()->organization_id)->where('user_id', $payment->author_id)->get()->first();
			
		// 	$payment['item_title'] = $item->title;
		// 	$payment['account_title'] = $account->title;
		// 	$payment['author_name'] = $author->name;
		// }

		// unset($payment);

		return view('payment.index', ['user' => $request->user()])->withpayments($payments);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$items = Item::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'item_id');
		$accounts = Account::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'account_id');

		$payment_hours = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 60, '', ' ч', 'H');
		$payment_minutes = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('00:59:00'), 1, '', ' мин', 'i');

		return view('payment.create', [	
										'items' => $items, 
										'accounts' => $accounts, 
										'payment_hours' => $payment_hours, 
										'payment_minutes' => $payment_minutes
									]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'beneficiary_title' => 'required',
			'item_id' => 'required',
			'account_id' => 'required'
		]);

		$payment = new Payment;

		$payment->item_id = $request->item_id;
		$payment->account_id = $request->account_id;
		$payment->beneficiary_type = $request->beneficiary_type;
		$payment->beneficiary_title = $request->beneficiary_title;
		$payment->sum = $request->sum;
		$payment->description = $request->description;
		$payment->date = date_create($request->input('payment-date').$request->input('payment-hour').':'.$request->input('payment-minute'));
		date_format($payment->date, 'U = Y-m-d H:i:s');
		$payment->author_id = $request->user()->user_id;
		$payment->organization_id = $request->user()->organization_id;

		$payment->save();

		Session::flash('success', 'Новый платеж успешно добавлен!');

		return redirect()->route('payment.show', $payment->payment_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		$payment = Payment::find($id);

		$item = Item::where('organization_id', $request->user()->organization_id)->where('item_id', $payment->item_id)->get()->first();
		$account = Account::where('organization_id', $request->user()->organization_id)->where('account_id', $payment->account_id)->get()->first();

		return view('payment.show', ['payment' => $payment, 'item' => $item, 'account' => $account]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$payment = Payment::find($id);
		$items = Item::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'item_id');
		$accounts = Account::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'account_id');

		$payment_hours = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 60, '', ' ч', 'H');
		$payment_minutes = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('00:59:00'), 1, '', ' мин', 'i');

		$dt = date_parse($payment->date);
		$payment_hour = $dt['hour'];
		$payment_minute = $dt['minute'];

		return view('payment.edit', [	
										'payment' => $payment, 
										'items' => $items, 
										'accounts' => $accounts, 
										'payment_hours' => $payment_hours, 
										'payment_minutes' => $payment_minutes,
										'payment_hour' => $payment_hour, 
										'payment_minute' => $payment_minute,
									]);
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
		$accessLevel = $request->user()->hasAccessTo('payment', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'beneficiary_title' => 'required',
			'item_id' => 'required',
			'account_id' => 'required'
		]);

		$payment = Payment::where('organization_id', $request->user()->organization_id)->where('payment_id', $id)->first();
		if (is_null($payment)) {
			return 'No such payment';
		}
		
		$payment->item_id = $request->item_id;
		$payment->account_id = $request->account_id;
		$payment->beneficiary_type = $request->beneficiary_type;
		$payment->beneficiary_title = $request->beneficiary_title;
		$payment->sum = $request->sum;
		$payment->description = $request->description;
		
		$payment->date = date_create($request->input('payment-date').$request->input('payment-hour').':'.$request->input('payment-minute'));
		date_format($payment->date, 'U = Y-m-d H:i:s');

		$payment->author_id = $request->user()->user_id;
		$payment->organization_id = $request->user()->organization_id;

		$payment->save();

		Session::flash('success', 'Новый платеж успешно добавлен!');

		return redirect()->route('payment.show', $payment->payment_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$payment = Payment::where('organization_id', $request->user()->organization_id)->where('payment_id', $id)->first();

		if ($payment) {
			$payment->delete();
			Session::flash('success', 'Платеж был успешно удален!');
		} else {
			Session::flash('error', 'Платеж не найден!');
		}

		return redirect()->route('payment.index');
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
