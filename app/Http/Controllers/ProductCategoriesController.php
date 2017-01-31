<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productCategories = ProductCategory::where('organization_id', $request->user()->organization_id)->get()->all();

        $page = Input::get('page', 1);
        $paginate = 10;
         
        $offset = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = array_slice($productCategories, $offset, $paginate, true);
        $productCategories = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($productCategories), $paginate, $page);
        $productCategories->setPath('productCategories');

        return view('productCategories.index', ['user' => $request->user()])->with(['productCategories' => $productCategories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $accessLevel = $request->user()->hasAccessTo('productCategories', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $this->validate($request, [
            'title' => 'required'
        ]);

        $productCategory = new ProductCategory;

        $productCategory->title = $request->title;            
        $productCategory->description = $request->description;
        $productCategory->parent_category_id = 0;
        $productCategory->organization_id = $request->user()->organization_id;

        $productCategory->save();

        Session::flash('success', 'Новая категория товара успешно добавлена!');

        return redirect()->route('productCategories.show', $productCategory->product_сategory_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productCategory = ProductCategory::find($id);

        return view('productCategories.show', ['productCategory' => $productCategory]);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productCategory = ProductCategory::find($id);

        return view('productCategories.edit', ['productCategory' => $productCategory]);
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
        $accessLevel = $request->user()->hasAccessTo('productCategories', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $this->validate($request, [
            'title' => 'required'
        ]);

        $productCategory = new ProductCategory;

        $productCategory->title = $request->title;            
        $productCategory->description = $request->description;
        $productCategory->parent_category_id = 0;
        $productCategory->organization_id = $request->user()->organization_id;

        $productCategory->save();

        Session::flash('success', 'Новая категория товара успешно добавлена!');

        return redirect()->route('productCategories.show', $productCategory->product_сategory_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $productCategory = ProductCategory::where('organization_id', $request->user()->organization_id)->where('product_category_id', $id)->first();

        if ($productCategory) {
            $productCategory->delete();
            Session::flash('success', 'Категория товара была успешно удалена из справочника!');
        } else {
            Session::flash('error', 'Категория товара не найдена в справочнике!');
        }

        return redirect()->route('productCategories.index');
    }
}
