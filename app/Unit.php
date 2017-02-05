<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
	protected $primaryKey = 'unit_id';

	protected $fillable = [
		'title',
		'short_title',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}


