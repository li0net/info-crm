<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

class Payment extends Model
{
	protected $primaryKey = 'payment_id';

	protected $fillable = [
		'date',
		'item_id',
		'account_id',
		'beneficiary_type',
		'beneficiary_id',
		'sum',
		'descrption',
		'author_id'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function item()
	{
		return $this->belongsTo(Item::class);
	}

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function partner()
	{
		return $this->belongsTo(Partner::class, 'beneficiary_id');
	}

	public function client()
	{
		return $this->belongsTo(Client::class, 'beneficiary_id');
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'beneficiary_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

	// public function itemtype() {
 //        return $this->belongsToThrough(Itemtype::class, Item::class);
 //    }

	public function itemtype()
	{
		//$this->belongsTo(Item::class, 'item_id', 'item_id');
		//dd($middle);
		
		return $this->item->belongsTo(Itemtype::class, 'itemtype_id', 'itemtype_id');
		// dd($end);

		// $end = $middle->belongsTo(Itemtype::class, 'itemtype_id', 'itemtype_id')->getResults();
		// dd($end);
	}	
}
