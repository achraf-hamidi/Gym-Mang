<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonners', function (Blueprint $table) {
            $table->id();
            $table->datetime('date_debut')->nullable();
            $table->datetime('date_fin')->nullable();
            $table->decimal('remise', 10, 2)->nullable();
            $table->float('prix_ttc')->nullable();
            $table->float('total_frais')->nullable();
            $table->integer('id_adherent');
            $table->boolean('has_new_abonnement')->default(0);
            $table->boolean('suspend')->default(0);
            $table->datetime('suspended_at')->nullable();
            $table->boolean('completed_paiement')->default(0);
            $table->date('paiament_date_echeance')->nullable();
            $table->integer('id_user');
            $table->integer('id_pack');
            $table->integer('id_abonnement');
            $table->timestamps();
        });

        Schema::create('abonnement_abonner', function (Blueprint $table) {
            $table->id();
            $table->datetime('date')->nullable();
            $table->boolean('is_active')->default(0);
            $table->integer('abonner_id');
            $table->integer('abonnement_id');
            $table->timestamps();
        });

        Schema::create('abonner_pack', function (Blueprint $table) {
            $table->id();
            $table->datetime('date')->nullable();
            $table->boolean('is_active')->default(0);
            $table->integer('abonner_id');
            $table->integer('pack_id');
            $table->decimal('promo', 10, 2)->nullable();
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
        Schema::dropIfExists('abonners');
        Schema::dropIfExists('abonnement_abonner');
        Schema::dropIfExists('pack_abonner');
    }
}
