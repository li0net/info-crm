<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeSetting;

class UploadImageController extends Controller
{
	public function uploadImage(Request $request, $id) {
		//$this->validate($request, ['avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

		$imageName = time().'.'.$request->file('avatar')->getClientOriginalExtension();

		$request->file('avatar')->move(public_path('images'), $imageName);

		$employee = Employee::find($id);
		$settings = EmployeeSetting::where('employee_id', $employee->employee_id)->get()->all();

		$settings[0]->email_for_notify = $imageName;

		$settings[0]->save();

		return back()->with('success', 'image uploaded successfully!')->with('path', $imageName);
	}
}
