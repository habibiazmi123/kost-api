<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomDiscussion extends Model
{
    use HasFactory;

    public function FromUser()
    {
        return $this->belongsTo(User::class, "from_id", "id");
    }

    public function ToUser()
    {
        return $this->belongsTo(User::class, "to_id", "id");
    }
}
