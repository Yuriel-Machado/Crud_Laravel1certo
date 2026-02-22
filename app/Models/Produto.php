<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'cep',
        'bairro',
        'cep_api',
        'logradouro',
        'cidade',
        'uf',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function anuncios()
    {
        return $this->belongsToMany(Anuncio::class, 'anuncio_produto')
            ->withPivot('quantidade')->withTimestamps();
    }
}