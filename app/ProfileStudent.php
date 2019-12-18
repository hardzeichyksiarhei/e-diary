<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileStudent extends Model
{
	protected $fillable = [
		'user_id', 'faculty_id', 'teacher_id', 'health_group_id', 'birthday', 'gender', 'course', 'group', 'disease'
	];

	protected $appends = [
		'disease_group_ids', 'faculty', 'teacher', 'health_group'
	];

	public function getDiseaseGroupIdsAttribute()
	{
		return $this->diseaseGroups->pluck('id');
	}

	public function getFacultyAttribute()
	{
		return $this->faculty()->first()['name'];
	}

	public function getTeacherAttribute()
	{
		return $this->teacher()->first()['name'];
	}

	public function getHealthGroupAttribute()
	{
		return $this->healthGroup()->first()['name'];
	}

	/**
	 * Relationships
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function teacher()
	{
		return $this->belongsTo('App\User');
	}

	public function faculty()
	{
		return $this->belongsTo('App\Faculty');
	}

	public function healthGroup()
	{
		return $this->belongsTo('App\HealthGroup');
	}

	public function diseaseGroups()
	{
		return $this->belongsToMany('App\DiseaseGroup');
	}
}
