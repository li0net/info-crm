<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Item
 *
 * @property int $item_id
 * @property string $title
 * @property int $itemtype_id
 * @property string $description
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Itemtype $itemtype
 * @property-read \App\Organization $organization
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereItemtypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Item extends Model
{
   protected $primaryKey = 'item_id';

	protected $fillable = [
		'title',
		'type',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function itemtype()
	{
		return $this->belongsTo(Itemtype::class, 'itemtype_id');
	}
}
