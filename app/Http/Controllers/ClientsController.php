<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Client;
use App\ClientCategory;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{

    protected $genderOptions;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissions');   //->only(['create', 'edit', 'save']);


        $this->genderOptions = [
            [
                'value' => 'null',
                'label' => trans('main.client:gender_unknown')
            ],
            [
                'value' => '1',
                'label' => trans('main.client:gender_men')
            ],
            [
                'value' => '0',
                'label' => trans('main.client:gender_woman')
            ],
        ];

        $this->importanceOptions = [
            [
                'value' => 'null',
                'label' => trans('main.client:importance_no_category')
            ],
            [
                'value' => 'bronze',
                'label' => trans('main.client:importance_bronze')
            ],
            [
                'value' => 'silver',
                'label' => trans('main.client:importance_silver')
            ],
            [
                'value' => 'gold',
                'label' => trans('main.client:importance_gold')
            ]
        ];
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
            'newClientUrl' => $newClientUrl,
            'crmuser' => $request->user()
        ]);
    }

    public function create(Request $request)
    {

        return view('client.form', [
            'clientCategoriesOptions' => $this->prepareClientCategoriesOptions(),
            'genderOptions' => $this->genderOptions,
            'importanceOptions' => $this->importanceOptions
        ]);
    }

    public function edit(Request $request, Client $client)
    {
        // TODO: выводить ошибку в красивом шаблоне
        if ($client->organization_id != $request->user()->organization_id) {
            return 'You don\'t have access to this item';
        }

        return view('client.form', [
            'clientCategoriesOptions' => $this->prepareClientCategoriesOptions(),
            'genderOptions' => $this->genderOptions,
            'importanceOptions' => $this->importanceOptions,
            'client' => $client
        ]);
    }

    public function show(Request $request, Client $client)
    {
        // TODO: выводить ошибку в красивом шаблоне
        if ($client->organization_id != $request->user()->organization_id) {
            return 'You don\'t have access to this item';
        }

        return view('client.show', [
            'clientCategoriesOptions' => $this->prepareClientCategoriesOptions(),
            'genderOptions' => $this->genderOptions,
            'importanceOptions' => $this->importanceOptions,
            'client' => $client
        ]);
    }

    /*
    public function gridData() {
        $je = new \App\Libraries\jqGridJsonEncoderCustom();
        $je->encodeRequestedData(new \App\GridRepositories\ClientsGridRepository(), Input::all());
    }
    */

    public function save(Request $request)
    {
        // TODO: поддержка нескольких категорий для одного клиента
        //  т.е. pivot таблица вместо client.category_id

        /*$request->all()
        array:14 [
          "_token" => "ygOp4keMmYgv9Y0E4qmvUS8pKY5qIATdWbMe3zHV"
          "name" => "Name"
          "phone" => 9992038844
          "email" => "email@site.com"
          "category_id" => "2"
          "gender" => "1"
          "importance" => "null"
          "discount" => "15"
          "birthday" => "05/10/15"
          "comment" => "comment here"
          "birthday_sms" => "1"
          "do_not_send_sms" => "1"
          "online_reservation_available" => "1"
          "total_bought" => "1500"
          "total_paid" => "1200"
        ]
        */

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'phone' => 'required|phone_crm',  // custom validation rule
            'email' => 'email',
            'discount' => 'regex:/^\d{0,2}$/',
            'birthday' => 'date',
            'total_bought' => 'numeric',
            'total_paid' => 'numeric'
        ]);
        if ($validator->fails()) {
            return redirect('/clients/create')
                ->withErrors($validator)
                ->with('clientCategoriesOptions', $this->prepareClientCategoriesOptions())
                ->with('genderOptions', $this->genderOptions)
                ->with('importanceOptions', $this->importanceOptions)
                ->withInput();
        }

        //TODO: валидация category_id, importance, gender - (проверяем что они есть в списках $this->prepareClientCategoriesOptions(),
        // $this->genderOptions, $this->importanceOptions)
        /*
        $durationSelects = $this->prepareDurationSelects();
        $isInArr = FALSE;
        foreach ($durationSelects['hours'] AS $option) {
            if ($option['value'] == $request->input('duration_hours')) {
                $isInArr = TRUE;
                break;
            }
        }
        if (!$isInArr) {
            return back()
                ->withErrors(['duration_hours' => 'Duration value is invalid.'])
                ->withInput();
        }
        */

        $clientPhone = $request->user()->normalizePhoneNumber($request->input('phone'));
        $gender = $request->input('gender');
        $importance = $request->input('importance');
        $birthday = $request->input('birthday');
        $comment = $request->input('comment');
        $bSms = $request->input('birthday_sms');
        $doNotSendSms = $request->input('do_not_send_sms');
        $onlineResAv = $request->input('online_reservation_available');
        $totalBought = $request->input('total_bought');
        $totalPaid = $request->input('total_paid');

        $cId = $request->input('client_id');
        // определить создание это или редактирование (по наличию поля client_id)
        // если редактирвоание - проверить что объект принадлежит текущей организации
        if (!is_null($cId)) {  // редактирование
            $client = Client::
            where('organization_id', $request->user()->organization_id)
                ->where('client_id', $cId)
                ->first();
            if (is_null($client)) {
                return 'Record doesn\'t exist';
            }

        } else {
            $client = new Client();
            $client->organization_id = $request->user()->organization_id;      // curr users's org id

        }

        $client->name = $request->input('name');
        $client->phone = $clientPhone;
        $client->email = $request->input('email');
        // TODO: поменять на запись в pivot таблицу
        $client->category_id = $request->input('category_id');
        $client->gender = ($gender == 'null') ? NULL : $gender;
        $client->importance = ($importance == 'null') ? NULL : $importance;
        $client->discount = $request->input('discount');
        $client->birthday = (trim($birthday) === '') ? NULL : date('Y-m-d', strtotime($birthday));
        $client->comment = (trim($comment) === '') ? NULL : $comment;
        $client->birthday_sms = ($bSms) ? '1' : '0';
        $client->do_not_send_sms = ($doNotSendSms) ? '1' : '0';
        $client->online_reservation_available = ($onlineResAv) ? '0' : '1';     // если чекбокс 'Запретить записываться онлайн' отмечен, в базу пишем false
        $client->total_bought = (is_null($totalBought)) ? NULL : round($totalBought, 4);
        $client->total_paid = (is_null($totalPaid)) ? NULL : round($totalPaid, 4);

        $client->save();

        if (!is_null($cId)) {
            Session::flash('success', trans('main.client:edit_success_message'));
        } else {
            Session::flash('success', trans('main.client:create_success_message'));
        }

        return redirect()->to('/clients');
    }

    private function prepareClientCategoriesOptions() {
        $clientCategoriesOptions = array();

        $clientCategories = ClientCategory::where('organization_id', request()->user()->organization_id)->get(); // ->get()
        foreach ($clientCategories AS $cc) {
            $clientCategoriesOptions[] = [
                'value'     => $cc->cc_id,
                'label'     => $cc->title,
                'color'     => trim($cc->color) != '' ? '#'.$cc->color : $cc->color
            ];
        }

        return $clientCategoriesOptions;
    }

    /**
     * Удаляет клиентов из БД
     *
     * @param $request Request
     */
    public function destroy(Request $request)
    {
        $cIds = $request->input('client_ids');
        if (!empty($cIds)) {
            $cIds = json_decode($cIds);
        } else {
            return json_encode(['success' => false, 'error' => 'Invalid data']);
        }

        //$clients = Client::where('organization_id', request()->user()->organization_id)->where('cc_id', 'IN', $cIds)->get();
        $updRes = DB::table('clients')
            ->where('organization_id', $request->user()->organization_id)
            ->whereIn('client_id', $cIds)
            ->update(['is_active' => 0]);
Log::info(__METHOD__.' updRes:'.var_export($updRes, TRUE)." | cIds:".var_export($cIds, TRUE));


        if (!$updRes) {
            return json_encode(['success' => false, 'error' => 'No records to delete found']);
        }

        return json_encode(['success' => true, 'error' => '']);
    }
}
