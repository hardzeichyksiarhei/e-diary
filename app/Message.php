<?php

namespace App;

use App\User;
use App\MessagesAttachment;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

  /*public static function boot() {
		parent::boot();

		static::deleted(function ($message) {
		});
	}*/

	protected $fillable = [
    'sender_id',
		'subject',
		'excerpt',
		'message'
	];

	protected $appends = [ 'sender', 'attachment' ];

  public function getSenderAttribute() {
		return User::withTrashed()->where('id', $this->sender_id)->first();
	}

  public function getAttachmentAttribute() {
		return MessagesAttachment::where('message_id', $this->id)->get();
  }

	public function messagesStatus()
  {
    return $this->hasMany('App\MessagesStatus');
  }

  public function attachment()
  {
    return $this->hasOne('App\MessagesAttachment');
  }
}
