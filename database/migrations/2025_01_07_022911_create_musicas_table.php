<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('musicas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('autor');
            $table->integer('ano')->nullable();
            $table->string('estilo')->nullable();
            $table->integer('visualizacoes')->nullable();
            $table->string('link');
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('ordem')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musicas');
    }
};
