<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomDiscussionResource;
use App\Http\Resources\RoomMessageResource;
use App\Services\PropertyService;
use App\Services\RoomDiscussionService;
use App\Services\RoomMessageService;
use Exception;
use Illuminate\Http\Request;

class RoomDiscussionApiController extends Controller
{
    protected $propertyService;
    protected $roomDiscussionService;
    protected $roomMessageService;

    public function __construct(PropertyService $propertyService, RoomDiscussionService $roomDiscussionService, RoomMessageService $roomMessageService)
    {
        $this->middleware("permission:ask_availability", ['only' => 'createDiscussion']);

        $this->propertyService = $propertyService;
        $this->roomDiscussionService = $roomDiscussionService;
        $this->roomMessageService = $roomMessageService;
    }

    public function getAllDiscussion()
    {
        try {
            $roomDiscussion = $this->roomDiscussionService->getAllByUserId(auth()->user()->id);

            return sendResponse(RoomDiscussionResource::collection($roomDiscussion));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

    public function getDiscussion($id)
    {
        try {
            $roomDiscussion = $this->roomDiscussionService->getById($id);

            if(!$roomDiscussion) return sendError("Room Discussion Not Found.");

            $this->authorize("view", $roomDiscussion);

            return sendResponse(new RoomDiscussionResource($roomDiscussion));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

    public function createDiscussion(Request $request)
    {
        $input = $request->only(["room_id"]);

        try {
            if(auth()->user()->credit_amount < 5) return sendError("Your credit is not enough.");

            $property = $this->propertyService->getById($input["room_id"]);

            if(!$property) return sendError("Property Not Found.");

            $roomDiscussion = $this->roomDiscussionService->checkAvailability(auth()->user()->id, $property->user_id);

            if(!$roomDiscussion) {
                $roomDiscussion = $this->roomDiscussionService->saveRoomDiscussion([
                    "to_id" => $property->user_id,
                    "subject" => "Check Available Room"
                ]);
            }

            $this->roomMessageService->sendMessage([
                "room_discussion_id" => $roomDiscussion->id,
                "sender_id" => auth()->user()->id,
                "message" => "Hallo saya " . auth()->user()->name . " ingin bertanya apakah " . $property->name . " masih kosong ?, Terimakasih"
            ]);

            auth()->user()->update(["credit_amount" => auth()->user()->credit_amount - 5]);

            return sendResponse(new RoomDiscussionResource($roomDiscussion));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

    public function sendMessage(Request $request)
    {
        $input = $request->only(["room_discussion_id", "message"]);

        try {
            $roomDiscussion = $this->roomDiscussionService->getAllByUserId($input["room_discussion_id"]);

            if(!$roomDiscussion) return sendError("Room Discussion Not Found.");

            $this->roomMessageService->sendMessage($roomDiscussion->id, $input["message"]);

            return sendSuccess("Success Message Sent.");
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

    public function getAllMessage(Request $request)
    {
        try {
            $roomMessage = $this->roomMessageService->getAllByRoomDiscussionId($request->room_discussion_id);

            return sendResponse(RoomMessageResource::collection($roomMessage));
        } catch (Exception $e) {
            return sendError($e->getMessage(), 500);
        }
    }

}
