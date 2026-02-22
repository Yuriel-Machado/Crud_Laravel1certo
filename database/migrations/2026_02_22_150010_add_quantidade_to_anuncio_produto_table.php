<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anuncio_produto', function (Blueprint $table) {
            if (!Schema::hasColumn('anuncio_produto', 'quantidade')) {
                $table->unsignedInteger('quantidade')->default(1)->after('produto_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('anuncio_produto', function (Blueprint $table) {
            if (Schema::hasColumn('anuncio_produto', 'quantidade')) {
                $table->dropColumn('quantidade');
            }
        });
    }
};
