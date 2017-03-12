<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Itemtype
 *
 * @property int $itemtype_id
 * @property string $title
 * @property string $category
 * @property string $description
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Item $item
 * @property-read \App\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Itemtype[] $payments
 * @method static \Illuminate\Database\Query\Builder|\App\Itemtype whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Itemtype whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Itemtype whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Itemtype whereItemtypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Itemtype whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Itemtype whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Itemtype whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Itemtype extends Model
{
   protected $primaryKey = 'itemtype_id';

	protected $fillable = [
		'title',
		'category',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function payments()
	{
		return $this->hasManyThrough('App\Itemtype', 'App\Item', 'itemtype_id', 'itemtype_id', 'item_id');
	}

	public function item()
	{
		return $this->hasOne(Item::class, 'itemtype_id');
	}
}
