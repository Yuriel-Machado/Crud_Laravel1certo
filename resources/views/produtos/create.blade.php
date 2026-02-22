@extends('layouts.app')
@section('title', 'Novo Produto')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold tracking-tight">Novo produto</h1>
        <p class="text-sm text-green-300">Cadastre um item físico (galpão) com localização e preço.</p>
    </div>

    <form method="POST" action="{{ route('produtos.store') }}" class="bg-zinc-900/70 backdrop-blur border border-green-800 rounded-2xl shadow-sm p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-green-300 mb-1">Nome</label>
                <input name="nome" value="{{ old('nome') }}"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300"
                       placeholder="Ex.: Notebook Dell" />
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-green-300 mb-1">Descrição</label>
                <textarea name="descricao" rows="4"
                          class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300"
                          placeholder="Descreva o produto...">{{ old('descricao') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-green-300 mb-1">Preço (custo)</label>
                <input name="preco" value="{{ old('preco') }}"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300"
                       placeholder="Ex.: 1499.90" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-green-300 mb-1">CEP</label>
                <input id="cep" name="cep" value="{{ old('cep') }}"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300"
                       placeholder="00000-000" />
                <p id="cep_status" class="mt-1 text-xs text-green-400"></p>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-green-300 mb-1">Bairro</label>
                <input id="bairro" name="bairro" value="{{ old('bairro') }}"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300"
                       placeholder="Ex.: Centro" />
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-2 sm:justify-end">
            <a href="{{ route('produtos.index') }}"
               class="px-4 py-2.5 rounded-xl border border-green-800 bg-zinc-900 hover:bg-black text-sm font-semibold text-green-300 text-center">
                Cancelar
            </a>
            <button class="px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-sm font-semibold">
                Salvar
            </button>
        </div>
    </form>
</div>

<script>
(() => {
  const cepInput = document.getElementById('cep');
  const bairroInput = document.getElementById('bairro');
  const statusEl = document.getElementById('cep_status');
  if (!cepInput || !bairroInput) return;

  let lastCep = null;
  let t = null;

  const setStatus = (msg, isError = false) => {
    if (!statusEl) return;
    statusEl.textContent = msg || '';
    statusEl.className = 'mt-1 text-xs ' + (isError ? 'text-red-300' : 'text-green-400');
  };

  const normalizeCep = (v) => (v || '').toString().replace(/\D/g, '').slice(0, 8);

  const applyMask = (raw) => {
    // 00000-000
    if (raw.length <= 5) return raw;
    return raw.slice(0,5) + '-' + raw.slice(5);
  };

  const fetchCep = async (cep8) => {
    setStatus('Buscando CEP...');
    try {
      const res = await fetch(`https://viacep.com.br/ws/${cep8}/json/`, { headers: { 'Accept': 'application/json' } });
      if (!res.ok) throw new Error('Falha na consulta');
      const data = await res.json();
      if (data?.erro) {
        setStatus('CEP não encontrado.', true);
        return;
      }
      // Preenche automaticamente o bairro (cliente não precisa digitar)
      bairroInput.value = data.bairro || '';
      setStatus('CEP encontrado. Bairro preenchido automaticamente.');
    } catch (e) {
      setStatus('Não foi possível consultar o CEP agora.', true);
    }
  };

  const maybeLookup = () => {
    const raw = normalizeCep(cepInput.value);
    // Mantém a máscara no campo
    cepInput.value = applyMask(raw);

    if (raw.length === 0) {
      setStatus('');
      lastCep = null;
      return;
    }

    if (raw.length !== 8) {
      setStatus('CEP deve ter 8 dígitos.');
      return;
    }

    if (raw === lastCep) return;
    lastCep = raw;
    fetchCep(raw);
  };

  const scheduleLookup = () => {
    clearTimeout(t);
    t = setTimeout(maybeLookup, 350);
  };

  // Busca ao sair do campo e também quando completar 8 dígitos
  cepInput.addEventListener('blur', maybeLookup);
  cepInput.addEventListener('input', scheduleLookup);
})();
</script>
@endsection
