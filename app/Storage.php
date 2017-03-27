<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Storage
 *
 * @property int $storage_id
 * @property string $title
 * @property bool $type
 * @property string $description
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @method static \Illuminate\Database\Query\Builder|\App\Storage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Storage whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Storage whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Storage whereStorageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Storage whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Storage whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Storage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Storage extends Model
{
	protected $primaryKey = 'storage_id';

	protected $fillable = [
		'title',
		'type',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
