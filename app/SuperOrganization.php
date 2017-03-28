<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SuperOrganization
 *
 * @property int $super_organization_id
 * @property string $name
 * @property int $tariff_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $shortinfo
 * @property string $info
 * @property string $website
 * @property string $primary_phone
 * @property string $secondary_phone
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Organization[] $organizations
 * @method static \Illuminate\Database\Query\Builder|\App\SuperOrganization whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SuperOrganization whereInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SuperOrganization whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SuperOrganization wherePrimaryPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SuperOrganization whereSecondaryPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SuperOrganization whereShortinfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SuperOrganization whereSuperOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SuperOrganization whereTariffId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SuperOrganization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SuperOrganization whereWebsite($value)
 * @mixin \Eloquent
 */
class SuperOrganization extends Model
{
    // db table name
    protected $table = 'super_organizations';
    protected $primaryKey = 'super_organization_id';

    protected $fillable = [
        'name',
        'shortinfo',
        'info',
        'website',
        'primary_phone',
        'secondary_phone'
    ];

    // 1:N relationship to organizations
    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }
}
