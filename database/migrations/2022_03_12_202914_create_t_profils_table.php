<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTProfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_profils', function (Blueprint $table) {
            $table->bigIncrements('r_i', 10)->unsigned();
            $table->char('r_code_profil', 4)->unique()->index();
            $table->string('r_libelle', 45)->unique()->index();
            $table->text('r_description')->nullable();
            $table->boolean('r_status')->default(0);
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
        Schema::dropIfExists('t_profils');
    }
}
