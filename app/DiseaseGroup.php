<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiseaseGroup extends Model
{
    protected $fillable = [
        'name', 'text'
    ];

	/**
	 * Relationships
	 */
	public function profileStudents()
	{
		return $this->belongsToMany('App\ProfileStudent');
	}
}
