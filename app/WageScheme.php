<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WageScheme extends Model
{
	protected $primaryKey = 'scheme_id';

	protected $fillable = [
		'scheme_name',
		'wage_rate',
		'services_percent',
		'products_percent',
		'wage_rate_period',
		'is_client_discount_counted',
		'is_material_cost_counted'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}
