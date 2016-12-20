<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	protected $primaryKey = 'employee_id';

	protected $fillable = [
		'name',
		'email',
		'phone'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function position()
	{
		return $this->hasOne('App\Position', 'position_id', 'position_id');
	}

	public function appointments()
	{
		return $this->hasMany(Appointment::class);
	}

	public function schedules()
	{
		return $this->hasMany(Schedule::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	// defining M:N relationship
	public function services()
	{
		return $this->belongsToMany(Service::class, 'employee_provides_service', 'employee_id', 'service_id');
	}
}
