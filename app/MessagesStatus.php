<?php

namespace App;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MessagesStatus extends Model
{
	protected $fillable = [
		'user_id',
		'message_id',
		'folder',
		'is_read',
		'is_starred'
	];

	protected $appends = [ 'message', 'user' ];

	public function getMessageAttribute()
	{
		return $this->message()->first();
  }
  
  public function getUserAttribute()
	{
		return User::find($this->user_id);
	}

	public function getCreatedAtAttribute($value)
	{
		$created_at = Carbon::parse($value);
		if ($created_at->isSameDay(Carbon::now()))
			return $created_at->format('H:i');
		elseif ($created_at->isCurrentMonth(Carbon::now()) && $created_at->isCurrentYear(Carbon::now()))
			return $created_at->format('j M');
		else
			return $created_at->format('d.m.y');
	}

	public function toggleStarred() {
		$this->is_starred = $this->is_starred == 1 ? 0 : 1;
		$this->save();
	}

	public function toggleTrash() {
		$this->folder = $this->is_starred == 1 ? 0 : 1;
		$this->save();
	}

	/*public static function boot()
	{
		parent::boot();

		static::deleted(function ($message) {
			$message->message()->doesntHave('messagesStatus')->delete();
		});
	}*/

	public function message()
  {
    return $this->belongsTo('App\Message');
	}
	
	public function user()
  {
    return $this->belongsTo('App\User');
  }
}
