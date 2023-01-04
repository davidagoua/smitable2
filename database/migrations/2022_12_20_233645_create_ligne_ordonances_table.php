<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_ordonances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('ordonance_id');
            $table->unsignedBigInteger('medicament_id');
            $table->string('frequence')->nullable();
            $table->unsignedInteger('quantite')->nullable();
            $table->unsignedInteger('prix')->nullable();
            $table->date('solded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligne_ordonances');
    }
};
