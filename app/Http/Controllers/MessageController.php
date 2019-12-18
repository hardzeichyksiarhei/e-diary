<?php

namespace App\Http\Controllers;

use App\Message;
use App\MessagesStatus;
use App\User;
use App\MessagesAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
	public function getMessageByID(Request $request, $id) {
		$message = MessagesStatus::find($id);
		if (!$message->is_read) $message->is_read = 1;
		$message->save();

		return $message;
	}

	public function getNotifications(Request $request) {
		$query = MessagesStatus::where([
			['user_id', $request->user()->id],
			['folder', 'inbox'],
			['status', 'active'],
			['is_read', 0]
		]);

		$notifications = $query
			->orderBy('created_at', 'desc')
			->limit(10)
			->get();

		return [
			'msg' => $notifications,
			'total' => $query->count()
		];
	}

	public function getInbox( Request $request ) {
		$inbox = MessagesStatus::where([
			['user_id', $request->user()->id],
			['folder', 'inbox'],
			['status', 'active']
		])
			->orderBy('created_at', 'desc')
			->paginate($request->per_page);

		return $inbox;
	}

	public function getStarred( Request $request ) {
		$starred = \DB::table('messages as m')
      ->join('messages_statuses as ms', function ($join) use ($request) {
          $join->on('m.id', 'ms.message_id')
              ->where([
                  ['ms.is_starred', 1],
                  ['ms.status', 'active']
              ])
              ->where(function ($query) use ($request) {
                return $query->where('m.sender_id', $request->user()->id)
                             ->orWhere('ms.user_id', $request->user()->id);
              });
      })
      ->join('users as sender', 'sender.id', '=', 'm.sender_id')
      ->join('users as receiver', 'receiver.id', '=', 'ms.user_id')
      ->select([
        'ms.id as id',
        'm.subject',
        'm.excerpt',
        'm.message',
        'sender.name as sender_name',
        'receiver.name as receiver_name',
        'm.sender_id',
        'ms.folder',
        'ms.is_read',
        'ms.is_starred',
        'm.created_at'
        ])
      ->orderBy('created_at', 'desc')
      ->paginate($request->per_page);

    $starred->getCollection()->transform(function ($item) {
      $created_at = Carbon::parse($item->created_at);
      if ($created_at->isSameDay(Carbon::now()))
        $item->created_at = $created_at->format('H:i');
      elseif ($created_at->isCurrentMonth(Carbon::now()) && $created_at->isCurrentYear(Carbon::now()))
        $item->created_at = $created_at->format('j M');
      else
        $item->created_at = $created_at->format('d.m.y');

      return $item;
    });
    
    return $starred;
	}

	public function getSent( Request $request ) {
    $sent = \DB::table('messages as m')->where('m.sender_id', $request->user()->id)
      ->join('messages_statuses as ms', function ($join) {
          $join->on('m.id', 'ms.message_id')
               ->where([
                  ['ms.folder', 'inbox'],
                  ['ms.status', 'active']
               ]);
      })
      ->join('users as sender', 'sender.id', '=', 'm.sender_id')
      ->join('users as receiver', 'receiver.id', '=', 'ms.user_id')
      ->select([
        'ms.id as id',
        'm.subject',
        'm.excerpt',
        'm.message',
        'sender.name as sender_name',
        'receiver.name as receiver_name',
        'ms.is_starred',
        'm.created_at'
        ])
      ->orderBy('created_at', 'desc')
      ->paginate($request->per_page);

    $sent->getCollection()->transform(function ($item) {
      $created_at = Carbon::parse($item->created_at);
      if ($created_at->isSameDay(Carbon::now()))
        $item->created_at = $created_at->format('H:i');
      elseif ($created_at->isCurrentMonth(Carbon::now()) && $created_at->isCurrentYear(Carbon::now()))
        $item->created_at = $created_at->format('j M');
      else
        $item->created_at = $created_at->format('d.m.y');

      return $item;
    });
    
    return $sent;
	}

	public function getTrash( Request $request ) {
		$sent = MessagesStatus::where([
			['user_id', $request->user()->id],
			['status', 'trash']
		])
			->orderBy('created_at', 'desc')
			->paginate(15);

		return $sent;
	}

	public function toggleStarred( Request $request, $id ) {
		return MessagesStatus::find($id)->toggleStarred();
	}

	public function sendMessage( MessageRequest $request ) {

		$receiver_ids = explode(',', $request->receiver_ids);

		$message = $request->text;

    $messageAttr = [
      'sender_id' => $request->user()->id,
      'subject' => $request->subject,
      'excerpt' => str_limit(strip_tags($message), 120, '...'),
      'message' => $message
    ];

    $message = Message::create($messageAttr);

    $uploaded_file = $request->file('attachment');

    if (!empty($uploaded_file)) {
      $this->validate($request, [
        'name' => 'required',
        'attachment' => 'file|mimes:' . MessagesAttachment::getAllExtensions() . '|max:' . MessagesAttachment::getMaxSize()
      ]);
  
      $attachment = new MessagesAttachment();
      $uploaded_file = $request->file('attachment');
      $original_ext = $uploaded_file->getClientOriginalExtension();
      $type = $attachment->getType($original_ext);
      if ($attachment->upload('attachment', $message, $type, $uploaded_file, $request['name'], $original_ext)) {
        $attachment = [
          'name' => $request['name'],
          'type' => $type,
          'extension' => $original_ext
        ];
      }
  
      $message->attachment()->create($attachment);
    }

		$messageStatusSenderAttr = [
			'user_id' => $request->user()->id,
			'folder' => 'sent'
		];

    $message->messagesStatus()->create($messageStatusSenderAttr);
    
    foreach ($receiver_ids as $receiver_id) {      
      $messageStatusReceiverAttr = [
        'user_id' => $receiver_id,
        'folder' => 'inbox'
      ];

      $message->messagesStatus()->create($messageStatusReceiverAttr);
    }

		return $message;
	}

	public function inTrash( Request $request )
	{
		if (empty($request->ids)) return;

		$messages = MessagesStatus::whereIn('id', $request->ids)->get();

		$messages->each(function ($item, $key) {
			$item->status = 'trash';
			$item->save();
		});

		return $messages;
	}

	public function outTrash( Request $request )
	{
		if (empty($request->ids)) return;

		$messages = MessagesStatus::whereIn('id', $request->ids)->get();

		$messages->each(function ($item, $key) {
			$item->status = 'active';
			$item->save();
		});

		return $messages;
	}

	public function delete( Request $request )
	{
		if (empty($request->ids)) return;

		$messages = MessagesStatus::destroy($request->ids);

		return $messages;
	}
}
