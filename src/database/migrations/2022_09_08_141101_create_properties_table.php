<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->string("name");
            $table->text("description");
            $table->integer("kost_type")->default(0);
            $table->float("latitude", 10, 7)->default(0);
            $table->float("longitude", 10, 7)->default(0);
            $table->text("address")->nullable();
            $table->float("price", 8, 2)->default(0);
            $table->integer("total_rooms")->default(0);
            $table->integer("total_available_rooms")->default(0);
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
        Schema::dropIfExists('properties');
    }
}
