@extends('layouts.app')
@section('title', 'Ver Produto')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Produto</h1>
            <p class="text-sm text-green-300">Detalhes do item armazenado.</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('produtos.edit', $produto) }}"
               class="px-4 py-2.5 rounded-xl border border-green-800 bg-zinc-900 hover:bg-black text-sm font-semibold text-green-300">
                Editar
            </a>
            <a href="{{ route('produtos.index') }}"
               class="px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-sm font-semibold">
                Voltar
            </a>
        </div>
    </div>

    <div class="bg-zinc-900/70 backdrop-blur border border-green-800 rounded-2xl shadow-sm p-6 space-y-4">
        <div>
            <div class="text-xs uppercase tracking-wide text-green-400">Nome</div>
            <div class="text-lg font-semibold">{{ $produto->nome }}</div>
        </div>

        <div>
            <div class="text-xs uppercase tracking-wide text-green-400">Descrição</div>
            <div class="text-green-100 whitespace-pre-line">{{ $produto->descricao }}</div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-zinc-900 border border-green-800">
                <div class="text-xs uppercase tracking-wide text-green-400">Preço (custo)</div>
                <div class="text-lg font-semibold">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
            </div>
            <div class="p-4 rounded-xl bg-zinc-900 border border-green-800">
                <div class="text-xs uppercase tracking-wide text-green-400">CEP</div>
                <div class="text-lg font-semibold">{{ $produto->cep }}</div>
            </div>
            <div class="p-4 rounded-xl bg-zinc-900 border border-green-800">
                <div class="text-xs uppercase tracking-wide text-green-400">Bairro</div>
                <div class="text-lg font-semibold">{{ $produto->bairro }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
