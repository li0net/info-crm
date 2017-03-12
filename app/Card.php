<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Card
 *
 * @property int $card_id
 * @property string $title
 * @property string $description
 * @property string $card_items
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Organization $organization
 * @method static \Illuminate\Database\Query\Builder|\App\Card whereCardId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Card whereCardItems($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Card whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Card whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Card whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Card whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Card extends Model
{
	protected $primaryKey = 'card_id';

	protected $fillable = [
		'title',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}
