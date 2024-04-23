<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->decimal('prix', 10, 2)->nullable(); // mois
            $table->integer('id_abonnement');
            $table->timestamps();
        });

        Schema::create('activitie_pack', function (Blueprint $table) {
            $table->id();
            $table->integer('pack_id');
            $table->integer('activitie_id');
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
        Schema::dropIfExists('packs');
        Schema::dropIfExists('activitie_pack');
    }
}
