<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ClientCategory
 *
 * @property int $cc_id
 * @property int $organization_id
 * @property string $title
 * @property string $color
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Client[] $clients
 * @property-read \App\Organization $organization
 * @method static \Illuminate\Database\Query\Builder|\App\ClientCategory whereCcId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClientCategory whereColor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClientCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClientCategory whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClientCategory whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClientCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClientCategory extends Model
{
    protected $table = 'client_categories';

    protected $primaryKey = 'cc_id';

    protected $fillable = [
        'title',
        'color'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'category_client', 'category_id', 'client_id');
    }
}
