<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Card;
use App\Storage;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CardController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$cards = Card::where('organization_id', $request->user()->organization_id)->get()->all();
		$items = array();
		$cards_items = array();

		foreach($cards as $card) {
			$items[] = json_decode($card->card_items);
		}

		foreach ($items as &$item) {
			foreach ($item[1] as $key => $value) {
				$storage = Storage::where('storage_id', $item[1][$key])->get(['title'])->all();
				$item[1][$key] = $storage[0]->title;
			}
		}

		unset($item);

		$i = 0;
		foreach($items as $item) {
			if(0 !== count($item[0])) {
				foreach ($item[0] as $key => $value) {
					$card_items[$i][] = array($value, $item[1][$key], $item[2][$key]);
				}
			}
			else {
				$card_items[$i] = null;
			}
			$i++;
		}

		// dd($card_items);

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($cards, $offset, $paginate, true);
		$cards = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($cards), $paginate, $page);
		$cards->setPath('card');

		$i = 0;
		foreach ($cards as $card) {
			$card->card_items = $card_items[$i];
			$i++;
		}

		// dd($cards);

		return view('card.index', ['user' => $request->user(), 'card_items' => $card_items])->withcards($cards);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$storages = Storage::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'storage_id');

		return view('card.create', ['storages' => $storages]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$accessLevel = $request->user()->hasAccessTo('card', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required'
		]);

		$input = $request->input();

		array_pop($input['product_id']);
		array_pop($input['storage_id']);
		array_pop($input['amount']);

		$card = new Card;

		$card->title = $request->title;
		$card->description = $request->description;
		$card->card_items = json_encode(array($input['product_id'],
												$input['storage_id'],
												$input['amount']));
		$card->organization_id = $request->user()->organization_id;

		$card->save();

		Session::flash('success', 'Новая технологическая карта успешно сохранена!');

		return redirect()->route('card.show', $card->storage_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$card = Card::find($id);

		return view('card.show', ['card' => $card]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$card = Card::find($id);
		$storages = Storage::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'storage_id');

		$card_items = array();

		// dd($card->card_items);

		if(null !== $card->card_items) {
			$items = json_decode($card->card_items);

			foreach ($items[0] as $key => $value) {
				$card_items[] = array($value, $items[1][$key], $items[2][$key]);
			}
		}

		return view('card.edit', ['card' => $card, 'storages' => $storages, 'card_items' => $card_items]);
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
		$accessLevel = $request->user()->hasAccessTo('card', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required'
		]);

		$input = $request->input();

		array_pop($input['product_id']);
		array_pop($input['storage_id']);
		array_pop($input['amount']);

		$card = card::where('organization_id', $request->user()->organization_id)->where('card_id', $id)->first();
		if (is_null($card)) {
			return 'No such card';
		}

		$card->title = $request->title;
		$card->card_items = json_encode(array($input['product_id'],
												$input['storage_id'],
												$input['amount']));
		$card->description = $request->description;
		$card->organization_id = $request->user()->organization_id;

		$card->save();

		Session::flash('success', 'Новая технологическая карта успешно сохранена!');

		return redirect()->route('card.show', $card->card_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$card = Card::where('organization_id', $request->user()->organization_id)->where('card_id', $id)->first();

		if ($card) {
			$card->delete();
			Session::flash('success', 'Технологическая карта была успешно удалена из справочника!');
		} else {
			Session::flash('error', 'Технологическая карта не найдена в справочнике!');
		}

		return redirect()->route('card.index');
	}
}
