<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depences', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->integer('service_id');
            $table->float('montant')->nullable();
            $table->datetime('date_commande')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_payed')->default(0);
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
        Schema::dropIfExists('depences');
    }
}
