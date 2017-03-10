<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Appointment
 *
 * @property int $appointment_id
 * @property int $organization_id
 * @property int $employee_id
 * @property int $client_id
 * @property int $service_id
 * @property string $start
 * @property string $end
 * @property string $note
 * @property int $remind_by_email_in
 * @property int $remind_by_sms_in
 * @property int $remind_by_phone_in
 * @property string $state
 * @property bool $is_employee_important
 * @property string $source
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Client $client
 * @property-read \App\Employee $employee
 * @property-read \App\Service $service
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereAppointmentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereIsEmployeeImportant($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereRemindByEmailIn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereRemindByPhoneIn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereRemindBySmsIn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Appointment extends Model
{

    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'start',
        'end',
        'remind_by_email_in',
        'remind_by_sms_in',
        'remind_by_phone_in',
        'is_confirmed'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
