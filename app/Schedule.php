<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Schedule
 *
 * @property int $schedule_id
 * @property string $work_start
 * @property string $work_end
 * @property int $employee_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Employee $employee
 * @method static \Illuminate\Database\Query\Builder|\App\Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Schedule whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Schedule whereScheduleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Schedule whereWorkEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Schedule whereWorkStart($value)
 * @mixin \Eloquent
 */
class Schedule extends Model
{

    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'work_start',
        'work_end'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
