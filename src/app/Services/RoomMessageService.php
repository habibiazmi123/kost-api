<?php

namespace App\Services;

use App\Repositories\RoomMessageRepository;

class RoomMessageService
{
    public $roomMessageRepository;

    public function __construct(RoomMessageRepository $roomMessageRepository)
    {
        $this->roomMessageRepository = $roomMessageRepository;
    }

    public function getAllByRoomDiscussionId($id)
    {
        return $this->roomMessageRepository->getAllByRoomDiscussionId($id);
    }

    public function sendMessage($input)
    {
        $result = $this->roomMessageRepository->save($input);

        return $result;
    }
}
