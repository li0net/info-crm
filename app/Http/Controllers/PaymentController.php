<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
		$payments = Payment::where('organization_id', $request->user()->organization_id)->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($payments, $offset, $paginate, true);
		$payments = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($payments), $paginate, $page);
		$payments->setPath('payment');

		return view('payment.index', ['user' => $request->user()])->withpayments($payments);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('payment.create');
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
		$payment->date = date_create($request->input('date').'00:00:00'); 	// Проверять дату
		$payment->author_id = 1; //$request->$request->user()->name;		// Автора брать из запроса
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
	public function show($id)
	{
		$payment = Payment::find($id);

		return view('payment.show', ['payment' => $payment]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$payment = Payment::find($id);

		return view('payment.edit', ['payment' => $payment]);
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
		
		$payment = new Payment;

		$payment->item_id = $request->item_id;
		$payment->account_id = $request->account_id;
		$payment->beneficiary_type = $request->beneficiary_type;
		$payment->beneficiary_title = $request->beneficiary_title;
		$payment->sum = $request->sum;
		$payment->description = $request->description;
		$payment->date = $request->date;
		$payment->author_id = 1;											// Автора брать из запроса
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
}
