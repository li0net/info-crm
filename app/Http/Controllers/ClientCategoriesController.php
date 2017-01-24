<?php

namespace App\Http\Controllers;

use App\Client;
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

    }
}
