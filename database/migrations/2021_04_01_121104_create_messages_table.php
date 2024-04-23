<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('message')->nullable();
            $table->timestamps();
        });

        Schema::create('message_user', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id');
            $table->integer('user_id');
            $table->integer('to_user_id');
            $table->boolean('seen_it')->default(0);
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
        Schema::dropIfExists('messages');
        Schema::dropIfExists('message_user');
    }
}
