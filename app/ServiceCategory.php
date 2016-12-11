<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
