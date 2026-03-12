<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_pets', function (Blueprint $table) {
            $table->id();
            $table->string("nome");
            $table->string("especie");
            $table->string("raca");
            $table->string("cor")->nullable();
            $table->date("data_nascimento")->nullable();
            $table->date("data_obito")->nullable();
            $table->string("sexo");
            $table->string("personalidade")->nullable();
            $table->text("observacoes")->nullable();
            $table->boolean("animal_chipado")->default(false);
            $table->string("numero_chip")->nullable();
            $table->string("foto")->nullable();
            $table->string("id_foto")->nullable();
            $table->dateTime("created_at")->useCurrent();
            $table->dateTime("updated_at")->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pets');
    }
};
