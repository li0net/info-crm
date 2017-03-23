<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partner;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PartnerController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$partners = Partner::where('organization_id', $request->user()->organization_id)->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($partners, $offset, $paginate, true);
		$partners = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($partners), $paginate, $page);
		$partners->setPath('partner');

		return view('partner.index', ['user' => $request->user()])->withpartners($partners);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return View
     */
	public function create()
	{
		return view('partner.create');
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
			'title' => 'required',
			'inn' => 'required',
			'kpp' => 'required'
		]);

		$partner = new Partner;

		$partner->title = $request->title;
		$partner->type = $request->type;
		$partner->inn = $request->inn;
		$partner->kpp = $request->kpp;
		$partner->contacts = $request->contacts;
		$partner->phone = $request->phone;
		$partner->email = $request->email;
		$partner->address = $request->address;
		$partner->description = $request->description;
		$partner->organization_id = $request->user()->organization_id;

		$partner->save();

		Session::flash('success', 'Новый контрагент успешно добавлен!');

		return redirect()->route('partner.show', $partner->partner_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return View
     */
	public function show($id)
	{
		$partner = Partner::find($id);

		return view('partner.show', ['partner' => $partner]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$partner = Partner::find($id);

		return view('partner.edit', ['partner' => $partner]);
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
		$accessLevel = $request->user()->hasAccessTo('partner', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required',
			'inn' => 'required',
			'kpp' => 'required'
		]);

		$partner = Partner::where('organization_id', $request->user()->organization_id)->where('partner_id', $id)->first();
		if (is_null($partner)) {
			return 'No such partner';
		}

		$partner->title = $request->title;
		$partner->type = $request->type;
		$partner->inn = $request->inn;
		$partner->kpp = $request->kpp;
		$partner->contacts = $request->contacts;
		$partner->phone = $request->phone;
		$partner->email = $request->email;
		$partner->address = $request->address;
		$partner->description = $request->description;
		$partner->organization_id = $request->user()->organization_id;

		$partner->save();

		Session::flash('success', 'Информация о контрагенте успешно сохранена!');

		return redirect()->route('partner.show', $partner->partner_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$partner = Partner::where('organization_id', $request->user()->organization_id)->where('partner_id', $id)->first();

		if ($partner) {
			$partner->delete();
			Session::flash('success', 'Контрагент был успешно удален из справочника!');
		} else {
			Session::flash('error', 'Контрагент не найден в справочнике!');
		}

		return redirect()->route('partner.index');
	}
}
