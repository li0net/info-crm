<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Account
 *
 * @property int $account_id
 * @property int $organization_id
 * @property string $title
 * @property string $type
 * @property float $balance
 * @property string $comment
 * @property int $position
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Account whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Account whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Account whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Account whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Account wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Account whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Account whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Account extends Model
{
	protected $primaryKey = 'account_id';

	protected $fillable = [
			'title',
			'comment'
	];
}
