<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
	protected $primaryKey = 'storage_id';

	protected $fillable = [
		'title',
		'type',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}
