<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("room_discussion_id");
            $table->foreign("room_discussion_id")->references("id")->on("room_discussions")->onDelete("cascade");
            $table->foreignId("sender_id");
            $table->foreign("sender_id")->references("id")->on("users")->onDelete("cascade");
            $table->text("message");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_messages');
    }
}
