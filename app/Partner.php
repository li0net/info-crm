<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
