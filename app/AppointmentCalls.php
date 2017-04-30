<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\AppointmentCalls
 *
 * @property int $id
 * @property int $appointment_id
 * @property int $client_id
 * @property datetime $date
 * @property string $title
 * @property text $description
 *
 */

class AppointmentCalls extends Model
{
    public $timestamps = false;
}
