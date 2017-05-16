<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\ProductCategory;
use App\StorageTransaction;
use App\Storage;
use App\Partner;
use App\Employee;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProductController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permissions');   //->only(['create', 'edit', 'save']);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$products = Product::where('organization_id', $request->user()->organization_id)->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($products, $offset, $paginate, true);
		$products = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($products), $paginate, $page);
		$products->setPath('product');

		return view('product.index', ['user' => $request->user()])->withproducts($products);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$storages = Storage::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'storage_id');
		$categories = ProductCategory::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'product_category_id');

		return view('product.create', compact('storages', 'categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$accessLevel = $request->user()->hasAccessTo('product', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required'
		]);

		$product = new Product;

		$product->title = $request->title;
		$product->article = $request->article;
		$product->barcode = $request->barcode;
		$product->category_id = $request->category_id;
		$product->storage_id = $request->storage_id;
		$product->price = $request->price;
		$product->unit_for_sale = $request->unit_for_sale;
		$product->amount = 0;
		$product->is_equal = $request->is_equal;
		$product->unit_for_disposal = $request->unit_for_disposal;
		$product->critical_balance = $request->critical_balance;
		$product->net_weight = $request->net_weight;
		$product->gross_weight = $request->gross_weight;
		$product->description = $request->description;
		$product->organization_id = $request->user()->organization_id;

		$product->save();

		Session::flash('success', trans('adminlte_lang::message.new_product_added'));

		return redirect()->route('product.show', $product->product_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		$product = Product::find($id);

		$storage = Storage::where('organization_id', $request->user()->organization_id)->where('storage_id', $product->storage_id)->get()->first();
		$category = ProductCategory::where('organization_id', $request->user()->organization_id)->where('product_category_id', $product->category_id)->get()->first();

		return view('product.show', compact('product', 'storage', 'category'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$product = Product::find($id);

		$storages = Storage::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'storage_id');
		$categories = ProductCategory::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'product_category_id');

		return view('product.edit', compact('product', 'storages', 'categories'));
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
		$accessLevel = $request->user()->hasAccessTo('product', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required'
		]);

		$product = Product::where('organization_id', $request->user()->organization_id)->where('product_id', $id)->first();
		if (is_null($product)) {
			return 'No such product';
		}

		$product->title = $request->title;
		$product->article = $request->article;
		$product->barcode = $request->barcode;
		$product->category_id = $request->category_id;
		$product->storage_id = $request->storage_id;
		$product->price = $request->price;
		$product->unit_for_sale = $request->unit_for_sale;
		$product->is_equal = $request->is_equal;
		$product->unit_for_disposal = $request->unit_for_disposal;
		$product->critical_balance = $request->critical_balance;
		$product->net_weight = $request->net_weight;
		$product->gross_weight = $request->gross_weight;
		$product->description = $request->description;
		$product->organization_id = $request->user()->organization_id;

		$product->save();

		Session::flash('success', 'Новый товар успешно сохранен!');

		return redirect()->route('product.show', $product->product_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$product = Product::where('organization_id', $request->user()->organization_id)->where('product_id', $id)->first();

		if ($product) {
			$product->delete();
			Session::flash('success', 'Товар был успешно удален из справочника!');
		} else {
			Session::flash('error', 'Товар не найден в справочнике!');
		}

		return redirect()->route('product.index');
	}

	public function storageBalance(Request $request)
	{
		$products = Product::where('organization_id', $request->user()->organization_id)->with('storage')->get()->all();
		$storages = Storage::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'storage_id');
		$partners = Partner::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'partner_id');
		$categories = ProductCategory::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'product_category_id');
		$user = $request->user();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($products, $offset, $paginate, true);
		$products = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($products), $paginate, $page);
		$products->setPath('product');

		return view('product.storagebalance', compact('user', 'products', 'storages', 'partners', 'categories'));
	}

	public function storageBalanceFiltered(Request $request)
	{
		$products = Product::where('organization_id', $request->organization_id);
		$storages = Storage::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'storage_id');
		$partners = Partner::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'partner_id');
		$categories = ProductCategory::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'product_category_id');
		$user = $request->user();

		if('' !== $request->storage_id) {
			$products = $products->where('storage_id', $request->storage_id);
		}

		if('' !== $request->category_id) {
			$products->where('category_id', $request->category_id);
		}

		if(1 == $request->show_critical_balance) {
			$products->whereRaw('products.amount < products.critical_balance');
		}

		$products = $products->with('storage')->get();

		$page = (0 == $request->page) ? 1 : $request->page;
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = $products->slice($offset, $paginate);
		$products = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($products), $paginate, $page);
		$products->setPath('storagebalance');
		$products->appends(['index' => 'filtered']);

		return View::make('product.list', compact('products'));
	}

	public function salesAnalysis(Request $request)
	{
		$transactions = StorageTransaction::where('organization_id', $request->user()->organization_id)->with('product.category')->get()->all();
		$employees = Employee::where('organization_id', $request->user()->organization_id)->get()->pluck('name', 'employee_id');
		$partners = Partner::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'partner_id');
		$categories = ProductCategory::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'product_category_id');
		$user = $request->user();

		//dd(storageTransaction::with('product.category')->get());

		$page = Input::get('page', 1);
		$paginate = 10;
		 

		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($transactions, $offset, $paginate, true);
		$transactions = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($transactions), $paginate, $page);
		$transactions->setPath('salesanalysis');

		return view('product.salesanalysis', compact('user', 'transactions', 'employees', 'partners', 'categories'));
	}

	public function salesAnalysisFiltered(Request $request)
	{
		$transactions = StorageTransaction::where('organization_id', $request->user()->organization_id)->with('product.category');
		$employees = Employee::where('organization_id', $request->user()->organization_id)->get()->pluck('name', 'employee_id');
		$partners = Partner::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'partner_id');
		$categories = ProductCategory::where('organization_id', $request->user()->organization_id)->get()->pluck('title', 'product_category_id');
		$user = $request->user();

		// $ttt = $transactions->get();
		// dd($ttt[0]->product->category->product_category_id);

		if('' !== $request->employee_id) {
			$transactions = $transactions->where('employee_id', $request->employee_id);
		}

		if('' !== $request->partner_id) {
			$transactions = $transactions->where('partner_id', $request->partner_id);
		}

		// if('' !== $request->category_id) {
		// 	$transactions->where('category_id', $request->category_id);
		// }

		if('' !== $request->category_id) {
			$transactions->whereIn('product_id', function($query) use ($request) {
				$query->select('product_id')->from('products')->where('category_id', $request->category_id);
			});
		}

		$filter_start_time = date_create($request->date_from.'00:00:00');
		date_format($filter_start_time, 'U = Y-m-d 0:0:0');

		$filter_end_time = date_create($request->date_to.'23:59:59');
		date_format($filter_end_time, 'U = Y-m-d 23:59:59');

		$transactions->whereBetween('date', [$filter_start_time, $filter_end_time]);

		$transactions = $transactions->with('product')->get();

		// dd($filter_start_time, $filter_end_time);

		$page = (0 == $request->page) ? 1 : $request->page;
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = $transactions->slice($offset, $paginate);
		$transactions = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($transactions), $paginate, $page);
		$transactions->setPath('salesanalysis');
		$transactions->appends(['index' => 'filtered']);

		return View::make('product.sales', compact('transactions'));
	}
}
