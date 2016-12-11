<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'type',
        'description',
        //'amount'
    ];

    public function organization() {
        $this->belongsTo(Organization::class);
    }

    public function employee()
    {
        $this->belongsTo(Employee::class);
    }

    public function service()
    {
        $this->belongsTo(Service::class);
    }
}
