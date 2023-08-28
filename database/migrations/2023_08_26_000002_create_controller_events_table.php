<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControllerEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controller_events', function (Blueprint $table) {
            $table->id();
            $table->dateTime('datetime');
            $table->string('event')->nullable();
            $table->boolean('status')->nullable();
            $table->string('data')->nullable();
            $table->integer('door_id')->nullable();
            $table->string('source')->nullable();
            $table->integer('source_id')->nullable();
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
        Schema::dropIfExists('controller_events');
    }
}
