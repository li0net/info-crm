<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $resources = Resource::where('organization_id', $request->user()->organization_id)->get()->all();
        $user = $request->user();

        $page = Input::get('page', 1);
        $paginate = 10;
         
        $offset = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = array_slice($resources, $offset, $paginate, true);
        $resources = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($resources), $paginate, $page);
        $resources->setPath('resource');

        return view('resource.index', compact('user', 'resources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resource.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $accessLevel = $request->user()->hasAccessTo('resource', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $this->validate($request, []);

        $resource = new Resource;

        $resource->name = $request->name;
        $resource->amount = 1;
        $resource->description = $request->description;
        $resource->organization_id = $request->user()->organization_id;

        $resource->save();

        Session::flash('success', 'Новый ресурс успешно сохранен!');

        return redirect()->route('resource.show', $resource->resource_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resource = Resource::find($id);

        return view('resource.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resource = resource::find($id);

        return view('resource.edit', compact('resource'));
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
        $accessLevel = $request->user()->hasAccessTo('resource', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $this->validate($request, []);

        $resource = resource::where('organization_id', $request->user()->organization_id)->where('resource_id', $id)->first();
        if (is_null($resource)) {
            return 'No such resource';
        }

        $resource->name = $request->name;
        $resource->amount = 1;
        $resource->description = $request->description;
        $resource->organization_id = $request->user()->organization_id;

        $resource->save();

        Session::flash('success', 'Новый ресурс успешно сохранен!');

        return redirect()->route('resource.show', $resource->storage_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = Resource::where('organization_id', $request->user()->organization_id)->where('resource_id', $id)->first();

        if ($resource) {
            $resource->delete();
            Session::flash('success', 'Ресурс был успешно удален из справочника!');
        } else {
            Session::flash('error', 'Ресурс не найден в справочнике!');
        }

        return redirect()->route('resource.index');
    }
}
