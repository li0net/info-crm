<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AccessPermission
 *
 * @property int $id
 * @property int $user_id
 * @property string $object
 * @property int $object_id
 * @property string $action
 * @property int $access_level
 * @property string $additional_settings
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $updated_by
 * @property string $description
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereAccessLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereAdditionalSettings($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereObject($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereObjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AccessPermission whereUserId($value)
 * @mixin \Eloquent
 */
class AccessPermission extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
