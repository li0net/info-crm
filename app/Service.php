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
        return $this->belongsTo(ServiceCategory::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    // defining M:N relationship
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_provides_service', 'service_id', 'employee_id');
    }
}
