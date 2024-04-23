<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFraisabonnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fraisabonners', function (Blueprint $table) { 
            $table->id();
            $table->integer('id_abonner')->nullable(); 
            $table->integer('id_assuranceps')->nullable(); 
            $table->float('prix', 10, 2)->nullable();
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
        Schema::dropIfExists('fraisabonners');
    }
}
