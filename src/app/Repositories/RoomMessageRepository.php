<?php

namespace App\Repositories;

use App\Models\RoomMessage;

class RoomMessageRepository
{
    protected $roomMessage;

    public function __construct(RoomMessage $roomMessage)
    {
        $this->roomMessage = $roomMessage;
    }

    public function getAllByRoomDiscussionId($id)
    {
        return $this->roomMessage->where('room_discussion_id', $id)->get();
    }

    public function save($data)
    {
        $roomMessage = new $this->roomMessage;

        $roomMessage->room_discussion_id = $data['room_discussion_id'];
        $roomMessage->sender_id = $data['sender_id'];
        $roomMessage->message = $data['message'];

        $roomMessage->save();

        return $roomMessage->fresh();
    }

}
