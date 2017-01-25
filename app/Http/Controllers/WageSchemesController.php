<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WageScheme;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class WageSchemesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$schemes = WageScheme::where('organization_id', $request->user()->organization_id)->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($schemes, $offset, $paginate, true);
		$schemes = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($schemes), $paginate, $page);
		$schemes->setPath('wage_scheme');

		return view('wage_schemes.index', ['user' => $request->user()])->withSchemes($schemes);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('wage_schemes.create');
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
			'scheme_name' => 'required',
			'services_percent' => 'required',
			'products_percent' => 'required'
		]);

		$scheme = new WageScheme;

		$scheme->scheme_name = $request->scheme_name;
		$scheme->services_percent = $request->services_percent;
		$scheme->service_unit = $request->service_unit;
		$scheme->products_percent = $request->products_percent;
		$scheme->products_unit = $request->products_unit;
		$scheme->wage_rate = $request->wage_rate;
		$scheme->wage_rate_period = $request->wage_rate_period;
		$scheme->is_client_discount_counted = $request->is_client_discount_counted;
		$scheme->is_material_cost_counted = $request->is_material_cost_counted;
		$scheme->organization_id = $request->user()->organization_id;
		$scheme->services_custom_settings = json_encode(array($request->services_cats_detailed,
																$request->services_detailed,
																$request->services_percent_detailed,
																$request->services_unit_detailed));
		$scheme->products_custom_settings = json_encode(array($request->products_cats_detailed,
																$request->products_detailed,
																$request->products_percent_detailed,
																$request->products_unit_detailed));

		$scheme->save();

		Session::flash('success', 'Новая схема расчета успешно добавлена!');

		return redirect()->route('wage_scheme.show', $scheme->scheme_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$scheme = WageScheme::find($id);

		return view('wage_schemes.show', ['scheme' => $scheme]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$scheme = WageScheme::find($id);

		return view('wage_schemes.edit', ['scheme' => $scheme]);
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
		$accessLevel = $request->user()->hasAccessTo('wage_schemes', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'scheme_name' => 'required',
			'services_percent' => 'required',
			'products_percent' => 'required'
		]);

		$scheme = WageScheme::where('organization_id', $request->user()->organization_id)->where('scheme_id', $id)->first();
		if (is_null($scheme)) {
			return 'No such scheme';
		}

		$scheme->scheme_name = $request->scheme_name;
		$scheme->services_percent = $request->services_percent;
		$scheme->service_unit = $request->service_unit;
		$scheme->products_percent = $request->products_percent;
		$scheme->products_unit = $request->products_unit;
		$scheme->wage_rate = $request->wage_rate;
		$scheme->wage_rate_period = $request->wage_rate_period;
		$scheme->is_client_discount_counted = $request->is_client_discount_counted;
		$scheme->is_material_cost_counted = $request->is_material_cost_counted;
		$scheme->organization_id = $request->user()->organization_id;
		$scheme->services_custom_settings = json_encode(array($request->services_cats_detailed,
																$request->services_detailed,
																$request->services_percent_detailed,
																$request->services_unit_detailed));
		$scheme->products_custom_settings = json_encode(array($request->products_cats_detailed,
																$request->products_detailed,
																$request->products_percent_detailed,
																$request->products_unit_detailed));

		$scheme->save();

		Session::flash('success', 'Информация о схеме расчета успешно обновлена!');

		return redirect()->route('wage_scheme.show', $scheme->scheme_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$scheme = WageScheme::where('organization_id', $request->user()->organization_id)->where('scheme_id', $id)->first();

		if ($scheme) {
			$scheme->delete();
			Session::flash('success', 'Схема была успешно удален из справочника!');
		} else {
			Session::flash('error', 'Схема не найдена в справочнике!');
		}

		return redirect()->route('wage_scheme.index');
	}
}
