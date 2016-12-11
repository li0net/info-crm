<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

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
        $this->belongsTo(Organization::class);
    }

    public function appointments()
    {
        $this->hasMany(Appointment::class);
    }

}
