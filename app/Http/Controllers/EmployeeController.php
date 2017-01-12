<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Employee;
use App\EmployeeSetting;
use App\Position;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Validator;

class EmployeeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permissions')->only(['update', 'destroy']);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		//$employees = Employee::OrderBy('employee_id', 'asc')->paginate(4);

		$employees = Employee::select('employee_id', 'name', 'email', 'phone', 'position_id', 'avatar_image_name')->with(['position' => function($query) { $query->select('position_id', 'title'); }])->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($employees, $offset, $paginate, true);
		$employees = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($employees), $paginate, $page);
		$employees->setPath('employee');
		 
		//return View::make('employee.index',compact('employees'));

		return view('employee.index', ['user' => $request->user()])->withEmployees($employees);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$items = Position::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'position_id');

		return view('employee.create', ['items' => $items]);
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
			'name' => 'required',
			'email' => 'required',
			'phone' => 'required'
		]);

		$employee = new Employee;
		$settings = new EmployeeSetting;

		$employee->name = $request->name;
		$employee->email = $request->email;
		$employee->phone = $request->phone;
		$employee->spec = $request->spec;
		$employee->descr = $request->descr;
		$employee->organization_id = $request->user()->organization_id;
		$employee->position_id = $request->position_id;
		if ($request->file('avatar') !== null) {
			$imageName = time().'.'.$request->file('avatar')->getClientOriginalExtension();

			$request->file('avatar')->move(public_path('images'), $imageName);

			$employee->avatar_image_name = $imageName;
		}

		$employee->save();

		$settings->employee_id = $employee->employee_id;
		$settings->session_start = date("Y-m-d H:i:s");
		$settings->session_end = date("Y-m-d H:i:s");
		$settings->revenue_pctg = 50;
		$settings->wage_scheme_id = 0;
		$settings->schedule_id = 0;

		$settings->save();

		Session::flash('success', 'Новый сотрудник успешно сохранен!');

		return redirect()->route('employee.show', $employee->employee_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$employee = Employee::where('organization_id', request()->user()->organization_id)->where('employee_id', $id)->first();

		if (!$employee) {
			return 'No such record';
		}

		return view('employee.show', ['user' => request()->user()])->withEmployee( $employee );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$employee = Employee::find($id);
		$settings = EmployeeSetting::where('employee_id', $employee->employee_id)->get()->all();

		$items = Position::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'position_id');

		return view('employee.edit', ['employee' => $employee, 'settings' => $settings, 'items' => $items]);
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
		//Проверяем есть ли у юзера права на редактирование Персонала
		$accessLevel = $request->user()->hasAccessTo('employee', 'edit', 0);
		if ($accessLevel < 1) {
			throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		}

		$this->validate($request, [
			// 'name' => 'required'
			// 'email' => 'required',
			// 'phone' => 'required'
			// 'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
		]);

		$validator = Validator::make($request->all(), [
      		'online_reg_notify' => 'exists'
    	]);

		$employee = Employee::where('organization_id', $request->user()->organization_id)->where('employee_id', $id)->first();
		if (is_null($employee)) {
			return 'No such employee';
		}

		$settings = EmployeeSetting::where('employee_id', $employee->employee_id)->get()->all();
		if (is_null($settings)) {
			return 'No such settings';
		}

		if ($request->input('id') == 'employee_form__info') {
			$employee->name = $request->input('name');
			// $employee->email = $request->input('email');
			// $employee->phone = $request->input('phone');
			$employee->spec = $request->input('spec');
			$employee->descr = $request->input('descr');
			$employee->position_id = $request->position_id;

			if ($request->file('avatar') !== null) {
				$imageName = time().'.'.$request->file('avatar')->getClientOriginalExtension();

				$request->file('avatar')->move(public_path('images'), $imageName);

				$employee->avatar_image_name = $imageName;
			}

			$employee->save();
		}

		if ($request->input('id') == 'employee_form__settings') {
			$settings[0]->online_reg_notify = $request->input('online_reg_notify');
			$settings[0]->phone_reg_notify = $request->input('phone_reg_notify');
			$settings[0]->online_reg_notify_del = $request->input('online_reg_notify_del');
			$settings[0]->phone_for_notify = $request->input('phone_for_notify');
			$settings[0]->email_for_notify = $request->input('email_for_notify');
			$settings[0]->online_reg_notify = $request->input('online_reg_notify');
			$settings[0]->client_data_notify = $request->input('client_data_notify');
			$settings[0]->reg_permitted = $request->input('reg_permitted');
			$settings[0]->reg_permitted_nomaster = $request->input('reg_permitted_nomaster');
			
			//TODO: Обрабатывать значения этих полей
			// $settings[0]->session_start = $request->input('session_start');
			// $settings[0]->session_end = $request->input('session_end');
			// $settings[0]->add_interval = $request->input('add_interval');

			$settings[0]->show_rating = $request->input('show_rating');
			$settings[0]->is_rejected = $request->input('is_rejected');
			$settings[0]->is_in_occupancy = $request->input('is_in_occupancy');
			$settings[0]->revenue_pctg = $request->input('revenue_pctg');
			$settings[0]->sync_with_google = $request->input('sync_with_google');
			$settings[0]->sync_with_1c = $request->input('sync_with_1c');

			$settings[0]->save();
		}

		Session::flash('success', 'Данные сотрудника успешно сохранены!');

		return redirect()->route('employee.show', $employee->employee_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$employee = Employee::where('organization_id', request()->user()->organization_id)->where('employee_id', $id)->first();
		$settings = EmployeeSetting::where('employee_id', $employee->employee_id)->get()->all();

		if ($employee) {
			$employee->delete();
			$settings[0]->delete();
			Session::flash('success', 'Сотрудник был успешно удален!');
		} else {
			Session::flash('error', 'Сотрудник не найден');
		}

		return redirect()->route('employee.index');
	}
}
