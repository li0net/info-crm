<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StorageTransaction extends Model
{
	protected $table = 'storage_transactions';
	protected $primaryKey = 'id';

	protected $fillable = [
		'type',
		'is_paidfor',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

		public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function partner()
	{
		return $this->belongsTo(Partner::class, 'partner_id');
	}

	public function client()
	{
		return $this->belongsTo(Client::class, 'client_id');
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id');
	}
}
