<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->datetime('date_paiement');
            $table->decimal('prix', 10, 2);
            $table->integer('id_abonner');
            $table->integer('id_adherent') ; //->default(0);
            $table->integer('id_user')->nullable();
            $table->integer('id_pack');
            $table->integer('id_abonnement');
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
        Schema::dropIfExists('paiements');
    }
}
