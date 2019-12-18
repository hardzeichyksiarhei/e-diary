<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileStaff extends Model
{
    protected $fillable = [
		'user_id', 'birthday', 'phone', 'position', 'rank', 'degree', 'description'
    ];
    
    /**
	 * Relationships
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
