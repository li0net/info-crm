<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Card;
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

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($cards, $offset, $paginate, true);
		$cards = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($cards), $paginate, $page);
		$cards->setPath('card');

		return view('card.index', ['user' => $request->user()])->withcards($cards);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('card.create');
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

		$card = new Card;

		$card->title = $request->title;
		$card->description = $request->description;
		$card->card_items = '';
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
	public function edit($id)
	{
		$card = Card::find($id);

		return view('card.edit', ['card' => $card]);
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

		$card = card::where('organization_id', $request->user()->organization_id)->where('card_id', $id)->first();
		if (is_null($card)) {
			return 'No such card';
		}

		$card->title = $request->title;
		$card->card_items = '';
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
