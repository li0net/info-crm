<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $primaryKey = 'service_id';

    protected $fillable = [
        'name',
        'description',
        'price_min',
        'price_max',
        'duration'
    ];

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_provides_service', 'service_id', 'employee_id')
                    ->withPivot('duration', 'routing_id');
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resources_attached_service', 'service_id', 'resource_id')
                    ->withPivot('amount');
    }

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
}
