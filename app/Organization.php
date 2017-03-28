<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Organization
 *
 * @property int $organization_id
 * @property int $super_organization_id
 * @property string $name
 * @property string $email
 * @property string $category
 * @property string $shortinfo
 * @property string $country
 * @property string $city
 * @property string $timezone
 * @property string $info
 * @property string $address
 * @property string $post_index
 * @property string $coordinates
 * @property string $website
 * @property string $work_hours
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $phone_1
 * @property string $phone_2
 * @property string $phone_3
 * @property string $logo_image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Position[] $positions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServiceCategory[] $serviceCategories
 * @property-read \App\SuperOrganization $superOrganization
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereCoordinates($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereLogoImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization wherePhone1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization wherePhone2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization wherePhone3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization wherePostIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereShortinfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereSuperOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereTimezone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereWorkHours($value)
 * @mixin \Eloquent
 * @property string $currency
 * @method static \Illuminate\Database\Query\Builder|\App\Organization whereCurrency($value)
 */
class Organization extends Model
{

    protected $primaryKey = 'organization_id';

    protected $fillable = [
        'name',
        'email',
        'shortinfo',
        'info',
        'website',
        'primary_phone',
        'secondary_phone',
        'country',
        'city',
        'timezone',
        'address',
        'post_index',
        'coordinates',
        'work_hours',
        'logo_image'
    ];

    public function superOrganization()
    {
        return $this->belongsTo(SuperOrganization::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function serviceCategories()
    {
        return $this->hasMany(ServiceCategory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * получает путь к лого организации
     * если лого нет  - возвращает пустое значение
     * @return string
     */
    public function getLogoUri() {
        $logoUri = asset('img/crm/avatar/avatar100.jpg');
        if ($this->logo_image){
            $logoPath = public_path() . '/uploaded_images/logo/main/' . $this->logo_image;
            if (file_exists($logoPath)) {
                $logoUri = asset('uploaded_images/logo/main/' . $this->logo_image);
            }
        }
        return $logoUri;
    }
}
