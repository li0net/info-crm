<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Unit
 *
 * @property int $unit_id
 * @property string $title
 * @property string $short_title
 * @property string $description
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Organization $organization
 * @method static \Illuminate\Database\Query\Builder|\App\Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Unit whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Unit whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Unit whereShortTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Unit whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Unit whereUnitId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Unit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Unit extends Model
{
	protected $primaryKey = 'unit_id';

	protected $fillable = [
		'title',
		'short_title',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}


