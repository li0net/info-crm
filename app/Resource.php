<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Resource
 *
 * @property int $resource_id
 * @property string $name
 * @property int $amount
 * @property string $description
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Service[] $services
 * @method static \Illuminate\Database\Query\Builder|\App\Resource whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Resource whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Resource whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Resource whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Resource whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Resource whereResourceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Resource whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Resource extends Model
{
	protected $primaryKey = 'resource_id';

	protected $fillable = [
		'name',
		'description',
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function services()
    {
        return $this->belongsToMany(Service::class, 'resources_attached_service', 'resource_id', 'service_id');
    }
}
