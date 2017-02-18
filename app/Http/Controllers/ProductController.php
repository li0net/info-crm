<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Storage;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProductController extends Controller
{
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

		return view('product.create', compact('storages'));
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
		$product->category = $request->category;
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

		Session::flash('success', 'Новый товар успешно добавлен!');

		return redirect()->route('product.show', $product->product_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$product = Product::find($id);

		return view('product.show', ['product' => $product]);
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

		return view('product.edit', compact('product', 'storages'));
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
		$product->category = $request->category;
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
}
