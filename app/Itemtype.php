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

	public function payments()
	{
		return $this->hasManyThrough('App\Itemtype', 'App\Item', 'itemtype_id', 'itemtype_id', 'item_id');
	}

	public function item()
	{
		return $this->hasOne(Item::class, 'itemtype_id');
	}
}
