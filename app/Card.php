<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
	protected $primaryKey = 'card_id';

	protected $fillable = [
		'title',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}
