<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // Guarda o JSON completo retornado pela ViaCEP
            $table->json('cep_api')->nullable()->after('bairro');

            // Campos úteis para consulta/visualização (preenchidos a partir da API)
            $table->string('logradouro')->nullable()->after('cep_api');
            $table->string('cidade')->nullable()->after('logradouro');
            $table->string('uf', 2)->nullable()->after('cidade');
        });
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn(['cep_api', 'logradouro', 'cidade', 'uf']);
        });
    }
};
