<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
