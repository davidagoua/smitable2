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
        Schema::create('appointements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('patient_id');
            $table->dateTime('start')->default(now());
            $table->dateTime('outed')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->longText('description')->nullable();
            $table->integer('etat')->default(0);
            $table->json('signe_fonctionel')->nullable();
            $table->json('motifs')->nullable();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointements');
    }
};
