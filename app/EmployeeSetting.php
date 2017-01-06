<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeSetting extends Model
{
	protected $table = 'employee_settings';

	protected $primaryKey = 'settings_id';

	public function employee()
	{
		return $this->hasOne('App\Employee', 'employee_id', 'employee_id');
	}
}
