<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WageScheme;
use App\ServiceCategory;
use App\Service;
use App\ProductCategory;
use App\Product;
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
	public function create(Request $request)
	{
		$service_ctgs = ServiceCategory::where('organization_id', $request->user()->organization_id)
										->orderBy('name')
										->with('service')
										->get()
										->pluck('service', 'service_category_id');

		$product_ctgs = ProductCategory::where('organization_id', $request->user()->organization_id)
										->orderBy('title')
										->with('product')
										->get()
										->pluck('product', 'product_category_id');

		return view('wage_schemes.create', ['service_ctgs' => $service_ctgs, 'product_ctgs' => $product_ctgs]);
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

		$input = $request->input();
		
		array_shift($input['services_cats_detailed']);
		array_shift($input['services_detailed']);
		array_shift($input['services_percent_detailed']);
		array_shift($input['services_unit_detailed']);
		array_shift($input['products_cats_detailed']);
		array_shift($input['products_detailed']);
		array_shift($input['products_percent_detailed']);
		array_shift($input['products_unit_detailed']);

		$scheme->scheme_name = $request->scheme_name;
		$scheme->services_percent = $request->services_percent;
		$scheme->service_unit = $request->service_unit;
		$scheme->products_percent = $request->products_percent;
		$scheme->products_unit = $request->products_unit;
		$scheme->wage_rate = $request->wage_rate;
		$scheme->wage_rate_period = $request->wage_rate_period;
		$scheme->is_client_discount_counted = ($request->is_client_discount_counted !== null );
		$scheme->is_material_cost_counted = ($request->is_material_cost_counted !== null );
		$scheme->organization_id = $request->user()->organization_id;
		$scheme->services_custom_settings = json_encode(array($input['services_cats_detailed'],
																$input['services_detailed'],
																$input['services_percent_detailed'],
																$input['services_unit_detailed']));
		$scheme->products_custom_settings = json_encode(array($input['products_cats_detailed'],
																$input['products_detailed'],
																$input['products_percent_detailed'],
																$input['products_unit_detailed']));

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
	public function edit(Request $request, $id)
	{
		$scheme = WageScheme::find($id);
		$service_ctgs = ServiceCategory::where('organization_id', $request->user()->organization_id)
										->orderBy('name')
										->with('service')
										->get()
										->pluck('service', 'service_category_id');

		$product_ctgs = ProductCategory::where('organization_id', $request->user()->organization_id)
										->orderBy('title')
										->with('product')
										->get()
										->pluck('product', 'product_category_id');

		$services_custom_settings = array();
		$products_custom_settings = array();

		if(null !== $scheme->services_custom_settings) {
			$services = json_decode($scheme->services_custom_settings);
			
			foreach ($services[0] as $key => $value) {
				$services_custom_settings[] = array($value, $services[1][$key], $services[2][$key], $services[3][$key]);
			}
		}

		if(null !== $scheme->products_custom_settings) {
			$products = json_decode($scheme->products_custom_settings);
			
			foreach ($products[0] as $key => $value) {
				$products_custom_settings[] = array($value, $products[1][$key], $products[2][$key], $products[3][$key]);
			}
		}

		//dd($service_ctgs);

		return view('wage_schemes.edit', ['scheme' => $scheme, 'service_ctgs' => $service_ctgs, 'product_ctgs' => $product_ctgs, 'services_custom_settings' => $services_custom_settings, 'products_custom_settings' => $products_custom_settings]);
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

		$input = $request->input();
		
		array_shift($input['services_cats_detailed']);
		array_shift($input['services_detailed']);
		array_shift($input['services_percent_detailed']);
		array_shift($input['services_unit_detailed']);
		array_shift($input['products_cats_detailed']);
		array_shift($input['products_detailed']);
		array_shift($input['products_percent_detailed']);
		array_shift($input['products_unit_detailed']);	

		$scheme->scheme_name = $request->scheme_name;
		$scheme->services_percent = $request->services_percent;
		$scheme->service_unit = $request->service_unit;
		$scheme->products_percent = $request->products_percent;
		$scheme->products_unit = $request->products_unit;
		$scheme->wage_rate = $request->wage_rate;
		$scheme->wage_rate_period = $request->wage_rate_period;
		$scheme->is_client_discount_counted = ( $request->is_client_discount_counted !== null );
		$scheme->is_material_cost_counted = ( $request->is_material_cost_counted !== null );
		$scheme->organization_id = $request->user()->organization_id;
		$scheme->services_custom_settings = json_encode(array($input['services_cats_detailed'],
																$input['services_detailed'],
																$input['services_percent_detailed'],
																$input['services_unit_detailed']));
		$scheme->products_custom_settings = json_encode(array($input['products_cats_detailed'],
																$input['products_detailed'],
																$input['products_percent_detailed'],
																$input['products_unit_detailed']));

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

	public function populateDetailedServiceOptions(Request $request)
    {
    	if($request->ajax()){
    		
    		$options = Service::where('service_category_id', $request->service_ctgs)->pluck('name', 'service_id')->all();

    		// if ($request->beneficiary_type == 'partner') {
    		// 	$options = Partner::where('organization_id', $request->user()->organization_id)->pluck('title', 'partner_id')->all();
    		// } elseif ($request->beneficiary_type == 'client') {
    		// 	$options = Client::where('organization_id', $request->user()->organization_id)->pluck('name', 'client_id')->all();
    		// } else {
    		// 	$options = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id')->all();
    		// }
    		
    		$data = view('wage_schemes.options', compact('options'))->render();
    		return response()->json(['options' => $data]);
    	}
    }

    public function populateDetailedProductOptions(Request $request)
    {
    	if($request->ajax()){
    		
    		$options = Product::where('category', $request->product_ctgs)->pluck('title', 'product_id')->all();

    		// if ($request->beneficiary_type == 'partner') {
    		// 	$options = Partner::where('organization_id', $request->user()->organization_id)->pluck('title', 'partner_id')->all();
    		// } elseif ($request->beneficiary_type == 'client') {
    		// 	$options = Client::where('organization_id', $request->user()->organization_id)->pluck('name', 'client_id')->all();
    		// } else {
    		// 	$options = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id')->all();
    		// }
    		
    		$data = view('wage_schemes.options', compact('options'))->render();
    		return response()->json(['options' => $data]);
    	}
    }
}
