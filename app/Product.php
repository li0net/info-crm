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

	public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category');
    }
}
