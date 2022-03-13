<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_utilisateurs', function (Blueprint $table) {
            $table->bigIncrements('r_i', 10)->unsigned();
            $table->string('r_nom', 25);
            $table->string('r_prenoms', 45)->nullable();
            $table->string('r_telephone', 15)->unique();
            $table->string('r_login', 15)->unique();
            $table->string('r_mdp', 255);
            $table->string('r_photo', 255)->nullable();
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
        Schema::dropIfExists('t_utilisateurs');
    }
}
