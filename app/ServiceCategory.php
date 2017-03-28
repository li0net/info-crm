<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ServiceCategory
 *
 * @property int $service_category_id
 * @property int $organization_id
 * @property string $name
 * @property string $online_reservation_name
 * @property bool $gender
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Service[] $services
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceCategory whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceCategory whereOnlineReservationName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceCategory whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceCategory whereServiceCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceCategory extends Model
{

    protected $table = 'service_categories';

    protected $primaryKey = 'service_category_id';

    protected $fillable = [
        'name',
        'online_reservation_name',
        'gender'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
