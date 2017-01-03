<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\User;

class UsersController extends Controller
{


    // users grid
    public function index()
    {

    }

    public function edit(Request $request)
    {
        return view('adminlte::services');
    }

    public function create(Request $request)
    {

    }
}
