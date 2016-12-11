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
        $this->belongsTo(SuperOrganization::class);
    }

    public function users()
    {
        $this->hasMany(User::class);
    }

    public function positions()
    {
        $this->hasMany(Position::class);
    }

    public function clients()
    {
        $this->hasMany(Client::class);
    }

    public function serviceCategories()
    {
        $this->hasMany(ServiceCategory::class);
    }

    public function transactions()
    {
        $this->hasMany(Transaction::class);
    }

}
