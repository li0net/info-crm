<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCategory extends Model
{
    protected $table = 'client_categories';

    protected $primaryKey = 'cc_id';

    protected $fillable = [
        'title',
        'color'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'category_client', 'category_id', 'client_id');
    }
}
