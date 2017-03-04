<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
	protected $primaryKey = 'resource_id';

	protected $fillable = [
		'name',
		'description',
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}
