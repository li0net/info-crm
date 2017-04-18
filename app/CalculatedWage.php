<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalculatedWage extends Model
{

    protected $fillable = ['employee_id', 'date_calculated', 'wage_period_start', 'wage_period_end', 'appointments_data', 'products_data', 'total_amount', 'wage_scheme_id'];

    public $timestamps = false;

    protected $primaryKey = 'cw_id';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
