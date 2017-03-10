<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Partner
 *
 * @property int $partner_id
 * @property string $type
 * @property string $title
 * @property string $inn
 * @property string $kpp
 * @property string $contacts
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $description
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Organization $organization
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereContacts($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereInn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereKpp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner wherePartnerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Partner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Partner extends Model
{
	protected $primaryKey = 'partner_id';

	protected $fillable = [
		'title',
		'inn',
		'kpp',
		'contacts',
		'phone',
		'email',
		'address',
		'descrption'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}
