<?php

namespace App;

use Carbon\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Storage;

use App\Traits\CalculateAge;

class User extends Authenticatable implements JWTSubject
{
	use Notifiable, CalculateAge;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name', 'last_name', 'patronymic_name', 'name', 'email', 'password', 'role'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = [
		'photo_url', 'profile', 'age'
	];

	/**
	 * Get the profile photo URL attribute.
	 *
	 * @return string
	 */
	public function getPhotoUrlAttribute()
	{
		return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
	}

	public function getProfileAttribute()
	{
		if ($this->role == 'student')
			return $this->profileStudent()->first();
		else
			return $this->profileStaff()->first();
	}

	public function getAgeAttribute()
	{
		if ($this->role == 'student')
			$birthday = $this->profileStudent['birthday'];

		if ($this->role == 'teacher' || $this->role == 'admin')
			$birthday = $this->profileStaff['birthday'];

		if ($birthday === '') return '';

		return self::calculateAge($birthday);
	}

	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->diffForHumans();
	}

	/**
	 * Get the oauth providers.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function oauthProviders()
	{
		return $this->hasMany(OAuthProvider::class);
	}

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswordNotification($token));
	}

	/**
	 * @return int
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}

	public function hasProfileActive()
	{
		if (!$this->has_profile) $this->has_profile = 1;
		$this->save();
	}


	public static function boot()
	{
		parent::boot();

		static::deleting(function ($user) {
			if ($user->role !== 'student') {
				$user_dir = explode('@', $user->email)[0] . '_' . $user->id;
				Storage::disk('documents')->deleteDirectory($user_dir);
			}
		});
	}

	/**
	 * Relationships
	 */
	public function profileStudent()
	{
		return $this->hasOne('App\ProfileStudent');
	}

	public function profileStaff()
	{
		return $this->hasOne('App\ProfileStaff');
	}

	public function functionalStates()
	{
		return $this->hasMany('App\FunctionalState');
	}

	public function physicalFitnesses()
	{
		return $this->hasMany('App\PhysicalFitness');
	}

	public function messages()
	{
		return $this->hasMany('App\Message', 'sender_id');
	}

	public function messagesStatus()
	{
		return $this->hasMany('App\MessagesStatus');
	}

	public function files()
	{
		return $this->hasMany('App\File');
	}

	public function share_files()
	{
		return $this->belongsToMany('App\File', 'file_user');
	}
}
