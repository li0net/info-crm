<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuperOrganization extends Model
{
    // db table name
    protected $table = 'super_organizations';
    protected $primaryKey = 'super_organization_id';

    protected $fillable = [
        'name',
        'shortinfo',
        'info',
        'website',
        'primary_phone',
        'secondary_phone'
    ];

    // 1:N relationship to organizations
    public function organizations()
    {
        $this->hasMany(Organization::class);
    }
}
