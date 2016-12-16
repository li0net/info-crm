<?php

namespace App\Http\Controllers;

class ServicesController extends Controller
{

    public function __construct()
    {
        // TODO: убрать после доработки логина
        auth()->loginUsingId(1);

        $this->middleware('auth');
    }


    /**
     * Show the service categories list
     *
     * @return Response
     */
    public function index()
    {
        return view('adminlte::services');
    }

}