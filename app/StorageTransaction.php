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

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id');
	}

	public function productWithCategories()
	{
		
		return $this->hasManyThrough(ProductCategory::class, Product::class, 'product_id', 'product_category_id', 'category_id');
		// $st = $this->belongsTo(Product::class, 'product_id')->getResults();

		// return $st->belongsTo(ProductCategory::class, 'category_id', 'product_category_id');
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

	public function storage1()
	{
		return $this->belongsTo(Storage::class, 'storage1_id');
	}

	public function storage2()
	{
		return $this->belongsTo(Storage::class, 'storage2_id');
	}
}
