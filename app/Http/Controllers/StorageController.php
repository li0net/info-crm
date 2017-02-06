<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Storage;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class StorageController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$storages = Storage::where('organization_id', $request->user()->organization_id)->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($storages, $offset, $paginate, true);
		$storages = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($storages), $paginate, $page);
		$storages->setPath('storage');

		return view('storage.index', ['user' => $request->user()])->withstorages($storages);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('storage.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$accessLevel = $request->user()->hasAccessTo('storage', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required'
		]);

		$storage = new storage;

		$storage->title = $request->title;
		$storage->type = $request->type;
		$storage->description = $request->description;
		$storage->organization_id = $request->user()->organization_id;

		$storage->save();

		Session::flash('success', 'Новый склад успешно сохранен!');

		return redirect()->route('storage.show', $storage->storage_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$storage = Storage::find($id);

		return view('storage.show', ['storage' => $storage]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$storage = Storage::find($id);

		return view('storage.edit', ['storage' => $storage]);
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
		$accessLevel = $request->user()->hasAccessTo('storage', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			'title' => 'required'
		]);

		$storage = storage::where('organization_id', $request->user()->organization_id)->where('storage_id', $id)->first();
		if (is_null($storage)) {
			return 'No such storage';
		}

		$storage->title = $request->title;
		$storage->type = $request->type;
		$storage->description = $request->description;
		$storage->organization_id = $request->user()->organization_id;

		$storage->save();

		Session::flash('success', 'Новый склад успешно сохранен!');

		return redirect()->route('storage.show', $storage->storage_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$storage = Storage::where('organization_id', $request->user()->organization_id)->where('storage_id', $id)->first();

		if ($storage) {
			$storage->delete();
			Session::flash('success', 'Склад была успешно удален из справочника!');
		} else {
			Session::flash('error', 'Склад не найден в справочнике!');
		}

		return redirect()->route('storage.index');
	}

	public function getStorageData(Request $request)
    {
    	//$data = array(['a' => 1, 'b' => 2, 'c' => 3], ['a' => 1, 'b' => 2, 'c' => 3], ['a' => 1, 'b' => 2, 'c' => 3]);
    	$storages = Storage::where('organization_id', $request->user()->organization_id)->get()->all();

    	echo json_encode($storages);
    }
}
