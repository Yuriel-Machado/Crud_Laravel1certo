<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anuncio_produto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('anuncio_id')
                ->constrained('anuncios')
                ->cascadeOnDelete();

            $table->foreignId('produto_id')
                ->constrained('produtos')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['anuncio_id', 'produto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anuncio_produto');
    }
};