<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(Product::class, 'category', 'product_category_id');
    }
}
