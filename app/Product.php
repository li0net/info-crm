<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';

	protected $fillable = [
		'title',
		'article',
		'barcode',
		'category',
		'price',
        'amount',
		'unit_for_sale',
		'is_equal',
		'unit_for_disposal',
		'critical_balance',
		'net_weight',
		'gross_weight',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'product_category_id');
    }

	public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'product_category_id');
    }

    public function storage()
	{
		return $this->belongsTo(Storage::class);
	}

	public function storageWithProducts()
	{
		$st = $this->belongsTo(Storage::class)->getResults();

		return $st->hasMany(Product::class);
	}
}
