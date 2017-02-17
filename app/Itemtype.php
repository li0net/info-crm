<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itemtype extends Model
{
   protected $primaryKey = 'itemtype_id';

	protected $fillable = [
		'title',
		'category',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	// public function payments()
	// {
	// 	return $this->hasManyThrough('App\Itemtype', 'App\Item', 'item_id', 'itemtype_id', 'payment_id');
	// }
}
