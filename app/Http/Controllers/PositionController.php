<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PositionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$positions = Position::select('position_id', 'title', 'description')->where('organization_id', $request->user()->organization_id)->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($positions, $offset, $paginate, true);
		$positions = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($positions), $paginate, $page);
		$positions->setPath('position');

		return view('position.index', ['user' => $request->user()])->withPositions($positions);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('position.create');
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

		$position = new Position;

		$position->title = $request->title;
		$position->description = $request->description;
		$position->organization_id = $request->user()->organization_id;

		$position->save();

		Session::flash('success', 'Новая должность успешно сохранена!');

		return redirect()->route('position.show', $position->position_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$position = Position::find($id);

		return view('position.show', ['position' => $position]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$position = Position::find($id);

		return view('position.edit', ['position' => $position]);
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
		$accessLevel = $request->user()->hasAccessTo('position', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required'
		]);

		$position = Position::where('organization_id', $request->user()->organization_id)->where('position_id', $id)->first();
		if (is_null($position)) {
			return 'No such position';
		}

		$position->title = $request->title;
		$position->description = $request->description;
		$position->organization_id = $request->user()->organization_id;

		$position->save();

		Session::flash('success', 'Новая должность успешно сохранена!');

		return redirect()->route('position.show', $position->position_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$position = Position::where('organization_id', $request->user()->organization_id)->where('position_id', $id)->first();

		if ($position) {
			$position->delete();
			Session::flash('success', 'Должность была успешно удалена из справочника!');
		} else {
			Session::flash('error', 'Должность не найдена в справочнике!');
		}

		return redirect()->route('position.index');
	}
}
