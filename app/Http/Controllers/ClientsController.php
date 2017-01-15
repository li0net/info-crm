<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\ClientCategory;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Session;


class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissions');   //->only(['create', 'edit', 'save']);
    }

    /**
     * Show the clients list with filters
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $newClientUrl = action('ClientsController@create');
        return view('client.index', [
            'newServiceUrl' => $newClientUrl,
            'crmuser' => $request->user()
        ]);
    }

    public function create(Request $request)
    {
        return 'Not implemented yet';
    }
}
