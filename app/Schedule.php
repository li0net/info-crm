<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'work_start',
        'work_end'
    ];

    public function employee()
    {
        $this->belongsTo(Employee::class);
    }
}
