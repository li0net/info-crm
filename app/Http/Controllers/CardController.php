<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Card;
use App\Storage;
use App\Product;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $cards = Card::where('organization_id', $request->user()->organization_id)->get()->all();
        $items = array();
        $card_items = array();
        $user = $request->user();

        foreach($cards as $card) {
            $items[] = json_decode($card->card_items);
        }

        foreach ($items as &$item) {
            foreach ($item[0] as $key => $value) {
                $storage = Storage::where('storage_id', $item[0][$key])->get(['title'])->all();
                $item[0][$key] = $storage[0]->title;
            }
            foreach ($item[1] as $key => $value) {
                $product = Product::where('product_id', $item[1][$key])->get(['title'])->all();
                $item[1][$key] = $product[0]->title;
            }
        }

        unset($item);

        $i = 0;
        foreach($items as $item) {
            if(0 !== count($item[0])) {
                foreach ($item[0] as $key => $value) {
                    $card_items[$i][] = array($value, $item[1][$key], $item[2][$key]);
                }
            } else {
                $card_items[$i] = null;
            }
            $i++;
        }

        $page = Input::get('page', 1);
        $paginate = 10;

        $offset = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = array_slice($cards, $offset, $paginate, true);
        $cards = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($cards), $paginate, $page);
        $cards->setPath('card');

        $i = $offset;
        foreach ($cards as $card) {
            $card->card_items = $card_items[$i];
            $i++;
        }

        return view('card.index', compact('user','cards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // getting the list of storages for select
        $stRows = Storage::where('organization_id', $request->user()->organization_id)->with('products')->get()->all();
        $storages = [];
        foreach ($stRows as $row){
            $storages[$row['storage_id']] = $row['title'];
        }

        return view('card.create', compact('storages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $accessLevel = $request->user()->hasAccessTo('card', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $this->validate($request, [
            'title' => 'required'
        ]);

        $input = $request->input();

        // removing empty strings
        $i = 0;
        foreach($input['storage_id'] as $prod){
            if ($prod == ''){
                unset($input['product_id'][$i]);
                unset($input['storage_id'][$i]);
                unset($input['amount'][$i]);
            }
            $i++;
        }

        $card = new Card;

        $card->title = $request->title;
        $card->description = $request->description;
        $card->card_items = json_encode(array(
                                $input['storage_id'],
                                $input['product_id'],
                                $input['amount']
                            ));

        $card->organization_id = $request->user()->organization_id;

        $card->save();

        Session::flash('success', trans('adminlte_lang::message.card_updated'));

        return redirect()->route('card.show', $card->storage_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $card = Card::find($id);

        return view('card.show', ['card' => $card]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // getting the list of storages for select
        $stRows = Storage::where('organization_id', $request->user()->organization_id)->with('products')->get()->all();
        $storages = [];
        foreach ($stRows as $row){
            $storages[$row['storage_id']] = $row['title'];
        }

        // getting the list of cards
        $cards = Storage::where('organization_id', $request->user()->organization_id)
                                    ->orderBy('title')
                                    ->with('products')
                                    ->get()
                                    ->pluck('products', 'storage_id');

        // get current card
        $card = Card::find($id);

        // get items of current card
        $card_items = array();
        if(null !== $card->card_items) {
            $items = json_decode($card->card_items);

            foreach ($items[0] as $key => $value) {
                $card_items[] = array($value, $items[1][$key], $items[2][$key]);
            }
        }

        return view('card.edit', compact('card', 'cards', 'storages', 'card_items'));
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
        $accessLevel = $request->user()->hasAccessTo('card', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $this->validate($request, [
            'title' => 'required'
        ]);
        // getting fields
        $input = $request->input();

        // removing empty strings
        $i = 0;
        foreach($input['storage_id'] as $prod){
            if ($prod == ''){
                unset($input['product_id'][$i]);
                unset($input['storage_id'][$i]);
                unset($input['amount'][$i]);
            }
            $i++;
        }

        $card = card::where('organization_id', $request->user()->organization_id)->where('card_id', $id)->first();
        if (is_null($card)) {
            return 'No such card';
        }
        $card->title = $request->title;
        $card->card_items = json_encode(array($input['storage_id'],
                                                $input['product_id'],
                                                $input['amount']));
        $card->description = $request->description;
        $card->organization_id = $request->user()->organization_id;

        $card->save();

        Session::flash('success', trans('adminlte_lang::message.card_updated'));

        return redirect()->route('card.show', $card->card_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $card = Card::where('organization_id', $request->user()->organization_id)->where('card_id', $id)->first();

        if ($card) {
            $card->delete();
            Session::flash('success', 'Технологическая карта была успешно удалена из справочника!');
        } else {
            Session::flash('error', 'Технологическая карта не найдена в справочнике!');
        }

        return redirect()->route('card.index');
    }

    public function populateProductOptions(Request $request)
    {
        if($request->ajax()){

            //выбираем только пролдукты,к оторые етьс на складе amount > 0
            $options = Product::where('storage_id', $request->storage_id)->where('amount', '>' , 0)->pluck('title', 'product_id')->all();

            $data = view('card.options', compact('options'))->render();
            return response()->json(['options' => $data]);
        }
    }
}

