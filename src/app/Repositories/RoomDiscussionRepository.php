<?php

namespace App\Repositories;

use App\Models\RoomDiscussion;

class RoomDiscussionRepository
{
    protected $roomDiscussion;

    public function __construct(RoomDiscussion $roomDiscussion)
    {
        $this->roomDiscussion = $roomDiscussion;
    }

    public function getById($id)
    {
        return $this->roomDiscussion->where('id', $id)->first();
    }

    public function getAllByUserId($id)
    {
        return $this->roomDiscussion->where('from_id', $id)->orWhere('to_id', $id)->get();
    }

    public function checkAvailability($from, $to)
    {
        return $this->roomDiscussion->where('from_id', $from)->where('to_id', $to)->first();
    }

    public function save($data)
    {
        $roomDiscussion = new $this->roomDiscussion;

        $roomDiscussion->from_id = auth()->user()->id;
        $roomDiscussion->to_id = $data['to_id'];
        $roomDiscussion->subject = $data['subject'];

        $roomDiscussion->save();

        return $roomDiscussion->fresh();
    }

}
