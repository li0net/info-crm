<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
   protected $primaryKey = 'item_id';

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
