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
        Schema::create('analyse_appointements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('analyse_id');
            $table->unsignedBigInteger('appointement_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analyse_appointements');
    }
};
