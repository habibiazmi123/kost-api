<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "user_id",
        "description",
        "kost_type",
        "latitude",
        "longitude",
        "address",
        "price",
        "total_rooms",
        "total_available_rooms"
    ];

    public function Owner() {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
