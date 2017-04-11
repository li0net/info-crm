<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleScheme extends Model
{

    protected $fillable = ['employee_id', 'start_date', 'schedule', 'fill_weeks'];

    public $timestamps = false;

    protected $primaryKey = 'ss_id';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
