<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assurances', function (Blueprint $table) {
            $table->id();
            $table->integer('id_adherent');
            $table->datetime('date_assuree')->default(now());
            $table->datetime('date_fin')->nullable();
            $table->integer('id_assureur')->nullable(); 
            $table->decimal('prix', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('assuranceps', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->integer('nb_mois')->nullable(); 
            $table->integer('id_typefrais')->nullable(); 
            $table->decimal('prix', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('typefrais', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable(); 
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
        Schema::dropIfExists('assurances');
        Schema::dropIfExists('assuranceps');
        Schema::dropIfExists('typefrais');
     }
}
