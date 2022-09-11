<?php

namespace App\Services;

use App\Repositories\RoomDiscussionRepository;
use InvalidArgumentException;

class RoomDiscussionService
{
    public $roomDiscussionRepository;

    public function __construct(RoomDiscussionRepository $roomDiscussionRepository)
    {
        $this->roomDiscussionRepository = $roomDiscussionRepository;
    }

    public function getById($id)
    {
        return $this->roomDiscussionRepository->getById($id);
    }

    public function getAllByUserId($userId)
    {
        return $this->roomDiscussionRepository->getAllByUserId($userId);
    }

    public function checkAvailability($from, $to)
    {
        return $this->roomDiscussionRepository->checkAvailability($from, $to);
    }

    public function saveRoomDiscussion($input)
    {
        $result = $this->roomDiscussionRepository->save($input);

        return $result;
    }
}
