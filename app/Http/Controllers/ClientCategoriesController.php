<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class ClientCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permissions');   //->only(['create', 'edit', 'save']);
    }

    /**
     * Show the client categories list
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $newCCUrl = action('ClientCategoriesController@create');

        return view('client_category.index', [
            'newCCUrl' => $newCCUrl,
            'crmuser' => $request->user()
        ]);
    }

    public function create(Request $request)
    {
        // проверяем, что у юзера есть права на Редактирование Услуг (в смысле 'управлния', т.е. создание сюда тоже входит)
        //$accessLevel = $request->user()->hasAccessTo('service', 'edit', 0);
        //if ($accessLevel < 1) {
            //throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        //}

        return view('client_category.form', ['crmuser' => $request->user()]);
    }

    public function edit(Request $request, ClientCategory $clientCategory)
    {
        // проверяем, что у юзера есть права на Редактирование Услуг (в смысле 'управлния', т.е. создание сюда тоже входит)
        //$accessLevel = $request->user()->hasAccessTo('service', 'edit', 0);
        //if ($accessLevel < 1) {
        //throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        //}

        $clientCategory->color = '#'.$clientCategory->color;
        return view('client_category.form', [
            'crmuser' => $request->user(),
            'clientCategory' => $clientCategory
        ]);
    }

    public function save(Request $request) {
        /*$request->all()
        Array
        (
            [_token] => 6Dsrc6u9SdMlj2Owzp1XxEPtrkTQBkz7YaHGYotp
            [name] => Спа
            [color] => #345566
        )
        */

        $this->validate($request, [
            'title' => 'required|max:120',
            'color' => 'required|max:7'
        ]);

        $ccId = $request->input('client_category_id');
        // определить создание это или редактирование (по наличию поля client_category_id)
        // если редактирвоание - проверить что объект принадлежит текущей организации
        if (!is_null($ccId)) {  // редактирование
            $cc = ClientCategory::
                where('organization_id', $request->user()->organization_id)
                ->where('cc_id', $ccId)
                ->first();
            if (is_null($cc)) {
                return 'Record doesn\'t exist';
            }

        } else {
            $cc = new ClientCategory();
            $cc->organization_id = $request->user()->organization_id;      // curr users's org id

        }

        $cc->title = $request->input('title');
        // color - пишем без #
        $cc->color = str_replace('#', '', $request->input('color'));

        $cc->save();

        if (!is_null($ccId)) {
            Session::flash('success', trans('main.client_category:edit_success_message'));
        } else {
            Session::flash('success', trans('main.client_category:create_success_message'));
        }

        return redirect()->to('/clientCategories');
    }

    /**
     * Удаляет категорию клиентов из БД
     *
     * @param  int  $ccId
     * @return \Illuminate\Http\Response
     */
    public function destroy($ccId)
    {
        $cc = ClientCategory::where('organization_id', request()->user()->organization_id)->where('cc_id', $ccId)->first();

        if ($cc) {
            // проверяем что у категории нет вложенных услуг
            $clientsCnt = $cc->client()->count();
            if ($clientsCnt > 0) {
                Session::flash('error', trans('main.client_category:delete_failed_has_clients_message', ['cnt' => $clientsCnt]));
            } else {
                $cc->delete();
            }
            Session::flash('success', trans('main.client_category:delete_success_message'));
        } else {
            Session::flash('error', trans('main.client_category:delete_error_message'));
        }

        return redirect()->to('/clientCategories');
    }
}
