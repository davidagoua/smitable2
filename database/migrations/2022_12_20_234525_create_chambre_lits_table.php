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
        Schema::create('chambre_lits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('unite')->nullable();
            $table->string('type')->nullable();
            $table->string('nom')->nullable();
            $table->unsignedInteger('nbr_place')->nullable();
            $table->unsignedInteger('stock')->default(1);
            $table->unsignedBigInteger('prix')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chambre_lits');
    }
};
