<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMessage extends Model
{
    use HasFactory;

    public function Sender()
    {
        return $this->belongsTo(User::class, "sender_id", "id");
    }
}
