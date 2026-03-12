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
        Schema::create('tb_historico_peso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained('tb_pets')->onDelete('cascade');
            $table->float('peso');
            $table->date('data_registro')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_historico_peso');
    }
};
