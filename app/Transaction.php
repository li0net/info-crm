<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Transaction
 *
 * @property int $transaction_id
 * @property int $organization_id
 * @property int $employee_id
 * @property int $service_id
 * @property float $amount
 * @property string $type
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Employee $employee
 * @property-read \App\Organization $organization
 * @property-read \App\Service $service
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereTransactionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'type',
        'description',
        //'amount'
    ];

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
