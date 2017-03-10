<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * App\Client
 *
 * @property int $client_id
 * @property int $organization_id
 * @property bool $is_active
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $importance
 * @property string $password
 * @property bool $gender
 * @property bool $discount
 * @property string $birthday
 * @property string $comment
 * @property bool $do_not_send_sms
 * @property bool $birthday_sms
 * @property bool $online_reservation_available
 * @property float $total_bought
 * @property float $total_paid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Appointment[] $appointments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ClientCategory[] $categories
 * @property-read \App\Organization $organization
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereBirthdaySms($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereDiscount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereDoNotSendSms($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereImportance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereOnlineReservationAvailable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereTotalBought($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereTotalPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Client extends Model
{

    protected $primaryKey = 'client_id';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'gender',
        'birthday',
        'comment',
        'do_not_send_sms',
        'birthday_sms',
        'online_reservation_available'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(ClientCategory::class, 'category_client', 'client_id', 'category_id');
    }

}
