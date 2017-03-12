<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Position
 *
 * @property int $position_id
 * @property int $organization_id
 * @property string $title
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employee[] $employees
 * @property-read \App\Organization $organization
 * @method static \Illuminate\Database\Query\Builder|\App\Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Position whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Position whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Position wherePositionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Position whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Position whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Position extends Model
{
	protected $primaryKey = 'position_id';

	protected $fillable = [
		'title',
		'description'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function employees()
	{
		return $this->hasMany(Employee::class);
	}
}
