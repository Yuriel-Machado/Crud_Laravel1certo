@extends('layouts.app')

@section('title', 'Produtos')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Produtos</h1>
            <p class="text-sm text-green-300">Itens físicos armazenados no galpão. Você só vê o que você criou.</p>
        </div>
        <a href="{{ route('produtos.create') }}"
           class="shrink-0 inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">
            <span class="text-base">＋</span> Novo produto
        </a>
    
    <form method="GET" action="{{ route('produtos.index') }}" class="flex flex-col md:flex-row gap-3 md:items-end bg-zinc-900/70 border border-green-800 rounded-2xl p-4">
        <div class="flex-1">
            <label class="block text-xs font-semibold text-green-300 mb-1">Pesquisar</label>
            <input name="q" value="{{ request('q') }}" placeholder="Nome, descrição, CEP, bairro..."
                   class="w-full bg-black/60 border border-green-900 rounded-xl px-3 py-2 text-sm text-white placeholder:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-green-700" />
        </div>

        <div class="w-full md:w-56">
            <label class="block text-xs font-semibold text-green-300 mb-1">Ordenar por</label>
            <select name="sort" class="w-full bg-black/60 border border-green-900 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-green-700">
                <option value="created_at" @selected(request('sort','created_at')==='created_at')>Mais recentes</option>
                <option value="nome" @selected(request('sort')==='nome')>Nome</option>
                <option value="preco" @selected(request('sort')==='preco')>Preço</option>
                <option value="cep" @selected(request('sort')==='cep')>CEP</option>
                <option value="bairro" @selected(request('sort')==='bairro')>Bairro</option>
            </select>
        </div>

        <div class="w-full md:w-36">
            <label class="block text-xs font-semibold text-green-300 mb-1">Direção</label>
            <select name="dir" class="w-full bg-black/60 border border-green-900 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-green-700">
                <option value="desc" @selected(request('dir','desc')==='desc')>Desc</option>
                <option value="asc" @selected(request('dir')==='asc')>Asc</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-green-700 text-black text-sm font-semibold hover:bg-green-600">
                Filtrar
            </button>
            <a href="{{ route('produtos.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-green-800 text-green-200 text-sm font-semibold hover:bg-black/40">
                Limpar
            </a>
        </div>
    </form>

</div>

    <div class="bg-zinc-900/70 backdrop-blur border border-green-800 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-black border-b border-green-800">
                    <tr class="text-green-300">
                        <th class="p-4 text-left font-semibold">Nome</th>
                        <th class="p-4 text-left font-semibold">Preço</th>
                        <th class="p-4 text-left font-semibold">CEP</th>
                        <th class="p-4 text-left font-semibold">Bairro</th>
                        <th class="p-4 text-right font-semibold">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($produtos as $produto)
                    <tr class="border-b border-green-900 hover:bg-black/50">
                        <td class="p-4">
                            <div class="font-semibold text-green-100">{{ $produto->nome }}</div>
                            <div class="text-xs text-green-400 line-clamp-1">{{ $produto->descricao }}</div>
                        </td>
                        <td class="p-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                        <td class="p-4">{{ $produto->cep }}</td>
                        <td class="p-4">{{ $produto->bairro }}</td>
                        <td class="p-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a class="px-3 py-1.5 rounded-lg border border-green-800 hover:bg-zinc-900 text-green-300"
                                   href="{{ route('produtos.show', $produto) }}">Ver</a>
                                <a class="px-3 py-1.5 rounded-lg border border-green-800 hover:bg-zinc-900 text-green-300"
                                   href="{{ route('produtos.edit', $produto) }}">Editar</a>
                                <form class="inline" method="POST" action="{{ route('produtos.destroy', $produto) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50"
                                            onclick="return confirm('Remover produto?')">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-8 text-center text-green-300" colspan="5">
                            Nenhum produto cadastrado ainda.
                            <div class="mt-2">
                                <a class="underline font-semibold" href="{{ route('produtos.create') }}">Criar o primeiro produto</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $produtos->links() }}
        </div>
    </div>
</div>
@endsection
