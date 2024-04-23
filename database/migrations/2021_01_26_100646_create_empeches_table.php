<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpechesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empeches', function (Blueprint $table) {
            $table->id();
            $table->integer('id_abonner');
            $table->integer('id_adherent');
            $table->integer('nb_jours');
            $table->string('empeche');
            $table->datetime('date_absence')->default(now());
            $table->datetime('date_retour')->default(now());
            $table->datetime('date_fin')->nullable();
            $table->datetime('old_date_fin_abonnement')->nullable();
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
        Schema::dropIfExists('empeches');
    }
}
