<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnuncioRequest;
use App\Http\Requests\UpdateAnuncioRequest;
use App\Models\Anuncio;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class AnuncioController extends Controller
{
    public function index()
    {
        $anuncios = Anuncio::query()
            ->where('user_id', Auth::id())
            ->with('produtos')
            ->latest()
            ->paginate(10);

        return view('anuncios.index', compact('anuncios'));
    }

    public function create()
    {
        $produtos = Produto::query()->where('user_id', Auth::id())->orderBy('nome')->get();
        return view('anuncios.create', compact('produtos'));
    }

    public function store(StoreAnuncioRequest $request)
    {
        $data = $request->validated();

        $anuncio = Anuncio::create([
            'titulo' => $data['titulo'],
            'descricao' => $data['descricao'],
            'preco_venda' => $data['preco_venda'],
            'user_id' => Auth::id(),
        ]);

        $this->ensureProdutoIdsOwned($data['produtos']);

        $quantidades = $request->input('quantidades', []);
        $syncData = [];
        foreach ($data['produtos'] as $produtoId) {
            $qtd = isset($quantidades[$produtoId]) ? (int) $quantidades[$produtoId] : 1;
            $syncData[$produtoId] = ['quantidade' => max(1, $qtd)];
        }

        $anuncio->produtos()->sync($syncData);

        return redirect()->route('anuncios.index')->with('success', 'Anúncio criado com sucesso.');
    }

    public function show(Anuncio $anuncio)
    {
        $this->ensureOwner($anuncio);

        $anuncio->load('produtos');
        return view('anuncios.show', compact('anuncio'));
    }

    public function edit(Anuncio $anuncio)
    {
        $this->ensureOwner($anuncio);

        $anuncio->load('produtos');
        $produtos = Produto::query()->where('user_id', Auth::id())->orderBy('nome')->get();
        $selecionados = $anuncio->produtos->pluck('id')->all();
        $quantidadesSelecionadas = $anuncio->produtos->pluck('pivot.quantidade', 'id')->all();

        return view('anuncios.edit', compact('anuncio', 'produtos', 'selecionados', 'quantidadesSelecionadas'));
    }

    public function update(UpdateAnuncioRequest $request, Anuncio $anuncio)
    {
        $this->ensureOwner($anuncio);

        $data = $request->validated();

        $anuncio->update([
            'titulo' => $data['titulo'],
            'descricao' => $data['descricao'],
            'preco_venda' => $data['preco_venda'],
            'user_id' => Auth::id(),
        ]);

        $this->ensureProdutoIdsOwned($data['produtos']);

        $quantidades = $request->input('quantidades', []);
        $syncData = [];
        foreach ($data['produtos'] as $produtoId) {
            $qtd = isset($quantidades[$produtoId]) ? (int) $quantidades[$produtoId] : 1;
            $syncData[$produtoId] = ['quantidade' => max(1, $qtd)];
        }

        $anuncio->produtos()->sync($syncData);

        return redirect()->route('anuncios.index')->with('success', 'Anúncio atualizado com sucesso.');
    }

    public function destroy(Anuncio $anuncio)
    {
        $this->ensureOwner($anuncio);

        $anuncio->delete();
        return redirect()->route('anuncios.index')->with('success', 'Anúncio removido com sucesso.');
    

    }
    private function ensureOwner(Anuncio $anuncio): void
    {
        if ($anuncio->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }
    }

    private function ensureProdutoIdsOwned(array $produtoIds): void
    {
        $count = Produto::query()
            ->where('user_id', Auth::id())
            ->whereIn('id', $produtoIds)
            ->count();

        if ($count !== count(array_unique($produtoIds))) {
            abort(403, 'Você só pode vincular produtos que você mesmo criou.');
        }
    }
}
