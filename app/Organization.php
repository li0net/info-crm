<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'work_hours'
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

}
