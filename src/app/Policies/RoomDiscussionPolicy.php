<?php

namespace App\Policies;

use App\Models\RoomDiscussion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class RoomDiscussionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Room  $roomDiscussion
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, RoomDiscussion $roomDiscussion)
    {
        return $user->id == $roomDiscussion->from_id || $user->id == $roomDiscussion->to_id;
    }

}
