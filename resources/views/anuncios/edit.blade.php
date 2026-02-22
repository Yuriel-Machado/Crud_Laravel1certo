@extends('layouts.app')
@section('title', 'Editar Anúncio')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold tracking-tight">Editar anúncio</h1>
        <p class="text-sm text-green-300">Atualize as informações e os produtos vinculados.</p>
    </div>

    <form method="POST" action="{{ route('anuncios.update', $anuncio) }}" class="bg-zinc-900/70 backdrop-blur border border-green-800 rounded-2xl shadow-sm p-6 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-green-300 mb-1">Título</label>
                <input name="titulo" value="{{ old('titulo', $anuncio->titulo) }}"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300" />
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-green-300 mb-1">Descrição</label>
                <textarea name="descricao" rows="4"
                          class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('descricao', $anuncio->descricao) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-green-300 mb-1">Preço de venda</label>
                <input name="preco_venda" value="{{ old('preco_venda', $anuncio->preco_venda) }}"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300" />
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-green-300 mb-2">Produtos do anúncio</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @php
                        $selecionados = old('produtos', $anuncio->produtos->pluck('id')->toArray());
                    @endphp
                    @forelse($produtos as $produto)
                        @php
                            $checked = in_array($produto->id, $selecionados);
                            $qtdDefault = $quantidadesSelecionadas[$produto->id] ?? 1;
                            $qtdOld = old('quantidades.' . $produto->id, $qtdDefault);
                        @endphp
                        <div class="flex items-start gap-3 p-3 rounded-xl border border-green-800 bg-zinc-900 hover:bg-black">
                            <input type="checkbox" name="produtos[]" value="{{ $produto->id }}"
                                   class="mt-1 rounded border-green-800 produto-check"
                                   data-produto-id="{{ $produto->id }}"
                                   @checked($checked) />
                            <div class="flex-1">
                                <div class="font-semibold">{{ $produto->nome }}</div>
                                <div class="text-xs text-green-400">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
                                <div class="mt-3 flex items-center gap-2">
                                    <label class="text-xs text-green-300" for="qtd-{{ $produto->id }}">Quantidade</label>
                                    <input id="qtd-{{ $produto->id }}" type="number" min="1"
                                           name="quantidades[{{ $produto->id }}]"
                                           value="{{ $qtdOld }}"
                                           class="w-24 border border-green-800 rounded-lg p-2 bg-black/40 focus:outline-none focus:ring-2 focus:ring-slate-300 produto-qtd"
                                           data-produto-id="{{ $produto->id }}"
                                           @disabled(!$checked) />
                                </div>
                                <div class="text-[11px] text-green-500 mt-1">Use quantidade &gt; 1 para repetir o mesmo produto no anúncio.</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-green-300">
                            Você ainda não tem produtos para vincular.
                            <a class="underline font-semibold" href="{{ route('produtos.create') }}">Criar produto</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-2 sm:justify-end">
            <a href="{{ route('anuncios.index') }}"
               class="px-4 py-2.5 rounded-xl border border-green-800 bg-zinc-900 hover:bg-black text-sm font-semibold text-green-300 text-center">
                Cancelar
            </a>
            <button class="px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-sm font-semibold">
                Atualizar
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        function syncQtdState() {
            document.querySelectorAll('.produto-check').forEach(function (chk) {
                var id = chk.getAttribute('data-produto-id');
                var qtd = document.querySelector('.produto-qtd[data-produto-id="' + id + '"]');
                if (!qtd) return;
                qtd.disabled = !chk.checked;
                if (chk.checked && (!qtd.value || parseInt(qtd.value, 10) < 1)) {
                    qtd.value = 1;
                }
            });
        }

        document.addEventListener('change', function (e) {
            if (e.target && e.target.classList.contains('produto-check')) {
                syncQtdState();
            }
        });

        syncQtdState();
    })();
</script>
@endpush
