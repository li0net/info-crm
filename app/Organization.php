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
        'work_hours',
        'logo_image'
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

    /**
     * получает путь к лого организации
     * @return string
     */
    public function getLogoUri() {
        $logoPath = public_path() . '/uploaded_images/logo/main/' . $this->logo_image;
        //echo $logoPath;
        //return $logoPath;
        if (file_exists($logoPath)) {
            $avatarUri = asset('uploaded_images/logo/main/' . $this->logo_image);
        } else {
            // дефолтный аватар
            //TODO исправить на /crm/
            $avatarUri = asset('uploaded_images/logo/logo100.jpg');
        }
        return $avatarUri;
    }

}
