<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Employee;
use App\EmployeeSetting;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

		$employees = Employee::select('employee_id', 'name', 'email', 'phone', 'position_id')->with(['position' => function($query) { $query->select('position_id', 'title'); }])->get()->all();

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
	public function create()
	{
		return view('employee.create');
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

		//$employee->employee_id = $request->employee_id;
		$employee->name = $request->name;
		$employee->email = $request->email;
		$employee->phone = $request->phone;
		$employee->spec = $request->spec;
		$employee->descr = $request->descr;
		$employee->organization_id = 2;
		$employee->position_id = $request->position_id;

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
	public function edit($id)
	{
		$employee = Employee::find($id);
		$settings = EmployeeSetting::where('employee_id', $employee->employee_id)->get()->all();

		return view('employee.edit', ['employee' => $employee, 'settings' => $settings]);
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
		// Проверяем есть ли у юзера права на редактирование Персонала
		// $accessLevel = $request->user()->hasAccessTo('employee', 'edit', 0);
		// if ($accessLevel < 1) {
		// 	throw new AccessDeniedHttpException('You don\'t have permission to access this page');
		// }

		$this->validate($request, [
			'name' => 'required'
			// 'email' => 'required',
			// 'phone' => 'required'
			// 'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
		]);

		$employee = Employee::where('organization_id', $request->user()->organization_id)->where('employee_id', $id)->first();
		if (is_null($employee)) {
			return 'No such record';
		}

		$employee->name = $request->input('name');
		// $employee->email = $request->input('email');
		// $employee->phone = $request->input('phone');
		$employee->spec = $request->input('spec');
		$employee->descr = $request->input('descr');
		$employee->position_id = $request->position_id;

		if($request->file('avatar') !== null) {
			$imageName = time().'.'.$request->file('avatar')->getClientOriginalExtension();

			$request->file('avatar')->move(public_path('images'), $imageName);

			$settings = EmployeeSetting::where('employee_id', $employee->employee_id)->get()->all();

			$settings[0]->avatar_image_name = $imageName;

			$settings[0]->save();
		}

		$employee->save();

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

		if ($employee) {
			$employee->delete();
			Session::flash('success', 'Сотрудник был успешно удален!');
		} else {
			Session::flash('error', 'Сотрудник не найден');
		}

		return redirect()->route('employee.index');
	}
}
