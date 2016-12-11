<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'name',
        'email',
        'phone'
    ];

    public function organization()
    {
        $this->belongsTo(Organization::class);
    }

    public function position()
    {
        $this->belongsTo(Position::class);
    }

    public function appointments()
    {
        $this->hasMany(Appointment::class);
    }

    public function schedules()
    {
        $this->hasMany(Schedule::class);
    }

    public function transactions()
    {
        $this->hasMany(Transaction::class);
    }

    // defining M:N relationship
    public function services()
    {
        return $this->belongsToMany(Service::class, 'employee_provides_service', 'employee_id', 'service_id');
    }
}
