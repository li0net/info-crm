<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductCategory
 *
 * @property int $product_category_id
 * @property string $title
 * @property string $description
 * @property int $parent_category_id
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $product
 * @method static \Illuminate\Database\Query\Builder|\App\ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductCategory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductCategory whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductCategory whereParentCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductCategory whereProductCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductCategory whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductCategory extends Model
{
    protected $table = 'product_categories';

    protected $primaryKey = 'product_category_id';

    protected $fillable = [
        'title',
        'description',
        'parent_category_id'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'category_id', 'product_category_id');
    }
}
