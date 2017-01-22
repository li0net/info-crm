<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

	protected $primaryKey = 'position_id';

	protected $fillable = [
		'title',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function employees()
	{
		return $this->hasMany(Employee::class);
	}
}
