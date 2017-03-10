<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EmployeeSetting
 *
 * @property int $settings_id
 * @property int $employee_id
 * @property bool $online_reg_notify
 * @property bool $phone_reg_notify
 * @property bool $online_reg_notify_del
 * @property bool $client_data_notify
 * @property string $email_for_notify
 * @property string $phone_for_notify
 * @property bool $reg_permitted
 * @property bool $reg_permitted_nomaster
 * @property bool $show_rating
 * @property bool $is_rejected
 * @property bool $is_in_occupancy
 * @property int $revenue_pctg
 * @property bool $sync_with_google
 * @property bool $sync_with_1c
 * @property int $wage_scheme_id
 * @property int $schedule_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $session_start
 * @property string $session_end
 * @property string $add_interval
 * @property-read \App\Employee $employee
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereAddInterval($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereClientDataNotify($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereEmailForNotify($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereIsInOccupancy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereIsRejected($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereOnlineRegNotify($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereOnlineRegNotifyDel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting wherePhoneForNotify($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting wherePhoneRegNotify($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereRegPermitted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereRegPermittedNomaster($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereRevenuePctg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereScheduleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereSessionEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereSessionStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereSettingsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereShowRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereSyncWith1c($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereSyncWithGoogle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeSetting whereWageSchemeId($value)
 * @mixin \Eloquent
 */
class EmployeeSetting extends Model
{
	protected $table = 'employee_settings';

	protected $primaryKey = 'settings_id';

	public function employee()
	{
		return $this->hasOne('App\Employee', 'employee_id', 'employee_id');
	}
}
