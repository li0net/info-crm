<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'start',
        'end',
        'remind_by_email_in',
        'remind_by_sms_in',
        'remind_by_phone_in',
        'is_confirmed'
    ];

    public function employee()
    {
        $this->belongsTo(Employee::class);
    }

    public function client()
    {
        $this->belongsTo(Client::class);
    }
}
