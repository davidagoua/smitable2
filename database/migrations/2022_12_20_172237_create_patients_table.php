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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code_patient')->unique();
            $table->string('index')->nullable();
            $table->integer('etat')->default(0);
            $table->string('nom')->nullable();
            $table->string('prenoms')->nullable();
            $table->enum('sexe', ['Homme','Femme'])->nullable();
            $table->string('nationalite')->nullable();
            $table->string('profession')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('domicile')->nullable();
            $table->string('situation_matrimoniale')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('scolarisation')->nullable();
            $table->boolean('actif')->default(false);
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
        Schema::dropIfExists('patients');
    }
};
