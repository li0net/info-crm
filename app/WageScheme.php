<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\WageScheme
 *
 * @property int $scheme_id
 * @property string $scheme_name
 * @property float $wage_rate
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $organization_id
 * @property float $services_percent
 * @property string $services_custom_settings
 * @property float $products_percent
 * @property string $products_custom_settings
 * @property string $wage_rate_period
 * @property bool $is_client_discount_counted
 * @property bool $is_material_cost_counted
 * @property string $products_unit
 * @property string $service_unit
 * @property-read \App\Organization $organization
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereIsClientDiscountCounted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereIsMaterialCostCounted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereProductsCustomSettings($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereProductsPercent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereProductsUnit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereSchemeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereSchemeName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereServiceUnit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereServicesCustomSettings($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereServicesPercent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereWageRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WageScheme whereWageRatePeriod($value)
 * @mixin \Eloquent
 */
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
