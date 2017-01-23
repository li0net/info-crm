<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ItemController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$items = Item::where('organization_id', $request->user()->organization_id)->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($items, $offset, $paginate, true);
		$items = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($items), $paginate, $page);
		$items->setPath('item');

		return view('item.index', ['user' => $request->user()])->withitems($items);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('item.create');
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
			'title' => 'required'            
		]);

		$item = new Item;

		$item->title = $request->title;
		$item->type = $request->type;
		$item->description = $request->description;
		$item->organization_id = $request->user()->organization_id;

		$item->save();

		Session::flash('success', 'Новая статья успешно добавлена!');

		return redirect()->route('item.show', $item->account_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$item = Item::find($id);

		return view('item.show', ['item' => $item]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$item = Item::find($id);

		return view('item.edit', ['item' => $item]);
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
		$accessLevel = $request->user()->hasAccessTo('item', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required',
		]);

		$item = item::where('organization_id', $request->user()->organization_id)->where('item_id', $id)->first();
		if (is_null($item)) {
			return 'No such item';
		}

		$item->title = $request->title;
		$item->type = $request->type;
		$item->description = $request->description;
		$item->organization_id = $request->user()->organization_id;

		$item->save();

		Session::flash('success', 'Информация о статье доходов-расходов успешно сохранена!');

		return redirect()->route('item.show', $item->partner_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$item = item::where('organization_id', $request->user()->organization_id)->where('item_id', $id)->first();

		if ($item) {
			$item->delete();
			Session::flash('success', 'Статья доходов-расходов была успешно удалена из справочника!');
		} else {
			Session::flash('error', 'Статья доходов-расходов не найдена в справочнике!');
		}

		return redirect()->route('item.index');
	}
}
