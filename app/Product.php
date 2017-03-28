<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property int $product_id
 * @property string $title
 * @property string $article
 * @property string $barcode
 * @property int $storage_id
 * @property int $category_id
 * @property float $price
 * @property int $amount
 * @property string $unit_for_sale
 * @property string $is_equal
 * @property string $unit_for_disposal
 * @property int $critical_balance
 * @property int $net_weight
 * @property int $gross_weight
 * @property string $description
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\ProductCategory $category
 * @property-read \App\Organization $organization
 * @property-read \App\ProductCategory $productCategory
 * @property-read \App\Storage $storage
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereArticle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereBarcode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCriticalBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereGrossWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereIsEqual($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereNetWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereStorageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereUnitForDisposal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereUnitForSale($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
