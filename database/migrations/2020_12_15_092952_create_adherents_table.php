<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdherentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adherents', function (Blueprint $table) {
            $table->id();
            $table->string('code_client')->unique();
            $table->integer('id_empreinte')->unique()->nullable();
            $table->string('qr_code')->unique();
            $table->string('nom')->nullable();
            $table->string('email')->nullable() ;//->unique();
            $table->string('password');
            $table->string('tele')->nullable();
            $table->string('tele_urgence')->nullable();
            $table->datetime('date_naiss')->nullable();
            $table->string('cin')->nullable();
            $table->string('gender')->nullable();
            $table->text('adresse')->nullable();
            $table->string('image')->default('homme.png');
            $table->boolean('is_valide')->default(0);
            $table->integer('id_adherent');
            $table->integer('id_user');
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
        Schema::dropIfExists('adherents');
    }
}
