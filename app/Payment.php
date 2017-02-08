<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $primaryKey = 'payment_id';

	protected $fillable = [
		'date',
		'item_id',
		'account_id',
		'beneficiary_type',
		'beneficiary_title',
		'sum',
		'descrption',
		'author_id'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}
