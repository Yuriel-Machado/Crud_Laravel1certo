<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Produto;
use App\Models\Anuncio;
use Illuminate\Support\Facades\Hash;

class SistemaSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
            ]
        );

        // Cliente (usuário comum)
        $cliente = User::updateOrCreate(
            ['email' => 'cliente@cliente.com'],
            [
                'name' => 'Cliente',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ]
        );

        // Produtos do Admin
        $produtosAdmin = [];
        for ($i = 1; $i <= 6; $i++) {
            $produtosAdmin[] = Produto::create([
                'user_id' => $admin->id,
                'nome' => 'Produto Admin ' . $i,
                'descricao' => 'Descrição do produto admin ' . $i,
                'preco' => rand(100, 1000),
                'cep' => '06000-000',
                'bairro' => 'Centro',
            ]);
        }

        // Produtos do Cliente
        $produtosCliente = [];
        for ($i = 1; $i <= 6; $i++) {
            $produtosCliente[] = Produto::create([
                'user_id' => $cliente->id,
                'nome' => 'Produto Cliente ' . $i,
                'descricao' => 'Descrição do produto cliente ' . $i,
                'preco' => rand(100, 1000),
                'cep' => '06000-000',
                'bairro' => 'Centro',
            ]);
        }

        // Anúncios do Admin (vinculando apenas produtos do Admin)
        for ($i = 1; $i <= 3; $i++) {
            $anuncio = Anuncio::create([
                'user_id' => $admin->id,
                'titulo' => 'Anúncio Admin ' . $i,
                'descricao' => 'Descrição do anúncio admin ' . $i,
                'preco_venda' => rand(500, 2000),
            ]);

            $ids = collect($produtosAdmin)->random(rand(1, 3))->pluck('id');
            $anuncio->produtos()->attach($ids);
        }

        // Anúncios do Cliente (vinculando apenas produtos do Cliente)
        for ($i = 1; $i <= 3; $i++) {
            $anuncio = Anuncio::create([
                'user_id' => $cliente->id,
                'titulo' => 'Anúncio Cliente ' . $i,
                'descricao' => 'Descrição do anúncio cliente ' . $i,
                'preco_venda' => rand(500, 2000),
            ]);

            $ids = collect($produtosCliente)->random(rand(1, 3))->pluck('id');
            $anuncio->produtos()->attach($ids);
        }
    }
}
