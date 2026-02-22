@extends('layouts.app')
@section('title', 'Ver Anúncio')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Anúncio</h1>
            <p class="text-sm text-green-300">Detalhes do anúncio e produtos vinculados.</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('anuncios.edit', $anuncio) }}"
               class="px-4 py-2.5 rounded-xl border border-green-800 bg-zinc-900 hover:bg-black text-sm font-semibold text-green-300">
                Editar
            </a>
            <a href="{{ route('anuncios.index') }}"
               class="px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-sm font-semibold">
                Voltar
            </a>
        </div>
    </div>

    <div class="bg-zinc-900/70 backdrop-blur border border-green-800 rounded-2xl shadow-sm p-6 space-y-4">
        <div>
            <div class="text-xs uppercase tracking-wide text-green-400">Título</div>
            <div class="text-lg font-semibold">{{ $anuncio->titulo }}</div>
        </div>

        <div>
            <div class="text-xs uppercase tracking-wide text-green-400">Descrição</div>
            <div class="text-green-100 whitespace-pre-line">{{ $anuncio->descricao }}</div>
        </div>

        <div class="p-4 rounded-xl bg-zinc-900 border border-green-800">
            <div class="text-xs uppercase tracking-wide text-green-400">Preço de venda</div>
            <div class="text-lg font-semibold">R$ {{ number_format($anuncio->preco_venda, 2, ',', '.') }}</div>
        </div>

        <div>
            <div class="text-xs uppercase tracking-wide text-green-400 mb-2">Produtos vinculados</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @forelse($anuncio->produtos as $produto)
                    <div class="p-3 rounded-xl border border-green-800 bg-zinc-900">
                        <div class="font-semibold flex items-center justify-between gap-3">
                            <span>{{ $produto->nome }}</span>
                            <span class="text-xs px-2 py-1 rounded-lg bg-black border border-green-800 text-green-300">
                                x{{ $produto->pivot->quantidade ?? 1 }}
                            </span>
                        </div>
                        <div class="text-xs text-green-400">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
                    </div>
                @empty
                    <div class="text-sm text-green-300">Nenhum produto vinculado.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
