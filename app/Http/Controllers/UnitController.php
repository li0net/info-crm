<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Unit;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UnitController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$units = Unit::where('organization_id', $request->user()->organization_id)->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($units, $offset, $paginate, true);
		$units = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($units), $paginate, $page);
		$units->setPath('unit');

		return view('unit.index', ['user' => $request->user()])->withunits($units);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('unit.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$accessLevel = $request->user()->hasAccessTo('unit', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required'
		]);

		$unit = new Unit;

		$unit->title = $request->title;
		$unit->short_title = $request->short_title;
		$unit->description = $request->description;
		$unit->organization_id = $request->user()->organization_id;

		$unit->save();

		Session::flash('success', 'Новая единица измерения успешно сохранена!');

		return redirect()->route('unit.show', $unit->unit_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$unit = Unit::find($id);

		return view('unit.show', ['unit' => $unit]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$unit = Unit::find($id);

		return view('unit.edit', ['unit' => $unit]);
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
		$accessLevel = $request->user()->hasAccessTo('unit', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required'
		]);

		$unit = unit::where('organization_id', $request->user()->organization_id)->where('unit_id', $id)->first();
		if (is_null($unit)) {
			return 'No such unit';
		}

		$unit->title = $request->title;
		$unit->short_title = $request->short_title;
		$unit->description = $request->description;
		$unit->organization_id = $request->user()->organization_id;

		$unit->save();

		Session::flash('success', 'Новая единица измерения успешно сохранена!');

		return redirect()->route('unit.show', $unit->unit_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$unit = Unit::where('organization_id', $request->user()->organization_id)->where('unit_id', $id)->first();

		if ($unit) {
			$unit->delete();
			Session::flash('success', 'Единица измерения была успешно удалена из справочника!');
		} else {
			Session::flash('error', 'Единица измерения не найдена в справочнике!');
		}

		return redirect()->route('unit.index');
	}
}
