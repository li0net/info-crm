<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Account;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accounts = Account::where('organization_id', request()->user()->organization_id)->get()->all();

        $page = Input::get('page', 1);
        $paginate = 10;
         
        $offset = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = array_slice($accounts, $offset, $paginate, true);
        $accounts = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($accounts), $paginate, $page);
        $accounts->setPath('account');

        return view('account.index', ['user' => $request->user()])->withAccounts($accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $account = new Account;

        $account->title = $request->title;
        $account->type = $request->type;
        $account->comment = $request->comment;
        $account->balance = $request->balance;
        $account->position = 1;
        $account->organization_id = $request->user()->organization_id;

        $account->save();

        Session::flash('success', 'Новый счет успешно добавлен!');

        return redirect()->route('account.show', $account->account_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Account::find($id);

        return view('account.show', ['account' => $account]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = Account::find($id);

        return view('account.edit', ['account' => $account]);
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
        $accessLevel = $request->user()->hasAccessTo('account', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $this->validate($request, [
            'title' => 'required'
        ]);

        $account = Account::where('organization_id', $request->user()->organization_id)->where('account_id', $id)->first();
        if (is_null($account)) {
            return 'No such account';
        }

        $account->title = $request->title;
        $account->type = $request->type;
        $account->balance = $request->balance;
        $account->comment = $request->comment;
        $account->position = 1;
        $account->organization_id = $request->user()->organization_id;

        $account->save();

        Session::flash('success', 'Информация о счете успешно обновлена!');

        return redirect()->route('account.show', $account->account_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $account = Account::where('organization_id', $request->user()->organization_id)->where('account_id', $id)->first();

        if ($account) {
            $account->delete();
            Session::flash('success', 'Счет был успешно удален из справочника!');
        } else {
            Session::flash('error', 'Счет не найден в справочнике!');
        }

        return redirect()->route('account.index');
    }
}
