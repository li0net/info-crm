<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSummary(Request $request)
    {
        $organization_id = $request->user()->organization_id;

        return view('summary', compact('organization_id'));
    }
}