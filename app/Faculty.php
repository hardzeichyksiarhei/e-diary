<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = [
        'name'
    ];

	/**
	 * Relationships
	 */
	public function profileStudent()
	{
		return $this->hasOne('App\ProfileStudent');
	}
}
