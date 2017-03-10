<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Payment
 *
 * @property int $payment_id
 * @property string $date
 * @property int $item_id
 * @property int $account_id
 * @property int $beneficiary_id
 * @property int $author_id
 * @property string $beneficiary_type
 * @property float $sum
 * @property string $description
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Account $account
 * @property-read \App\Client $client
 * @property-read \App\Employee $employee
 * @property-read \App\Item $item
 * @property-read \App\Organization $organization
 * @property-read \App\Partner $partner
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereAuthorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereBeneficiaryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereBeneficiaryType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment wherePaymentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereSum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Payment extends Model
{
	protected $primaryKey = 'payment_id';

	protected $fillable = [
		'date',
		'item_id',
		'account_id',
		'beneficiary_type',
		'beneficiary_id',
		'sum',
		'descrption',
		'author_id'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function item()
	{
		return $this->belongsTo(Item::class);
	}

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function partner()
	{
		return $this->belongsTo(Partner::class, 'beneficiary_id');
	}

	public function client()
	{
		return $this->belongsTo(Client::class, 'beneficiary_id');
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'beneficiary_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

	public function itemtype()
	{
		return $this->item->belongsTo(Itemtype::class, 'itemtype_id', 'itemtype_id');
	}
}
