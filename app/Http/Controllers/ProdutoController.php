<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $sort = (string) $request->query('sort', 'created_at');
        $dir = strtolower((string) $request->query('dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSorts = ['nome', 'preco', 'cep', 'bairro', 'created_at'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        $query = Produto::query()->where('user_id', Auth::id());

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('nome', 'like', "%{$q}%")
                    ->orWhere('descricao', 'like', "%{$q}%")
                    ->orWhere('cep', 'like', "%{$q}%")
                    ->orWhere('bairro', 'like', "%{$q}%")
                    ->orWhere('logradouro', 'like', "%{$q}%")
                    ->orWhere('cidade', 'like', "%{$q}%")
                    ->orWhere('uf', 'like', "%{$q}%");
            });
        }

        $produtos = $query->orderBy($sort, $dir)->paginate(10)->appends($request->query());

        return view('produtos.index', compact('produtos', 'q', 'sort', 'dir'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(StoreProdutoRequest $request)
    {
        $payload = $request->validated();

        // Consulta CEP na ViaCEP e guarda retorno no banco
        $cepData = $this->fetchCepData($payload['cep'] ?? '');
        if ($cepData) {
            $payload['cep_api'] = $cepData ? json_encode($cepData, JSON_UNESCAPED_UNICODE) : null;
            #se vier vazio da certo.
            $payload['bairro'] = $cepData['bairro'] ?? $payload['bairro'];
            $payload['logradouro'] = $cepData['logradouro'] ?? null;
            $payload['cidade'] = $cepData['localidade'] ?? null;
            $payload['uf'] = $cepData['uf'] ?? null;
        }

        Produto::create(array_merge($payload, ['user_id' => Auth::id()]));
        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso.');
    }

    public function show(Produto $produto)
    {
        $this->ensureOwner($produto);

        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        $this->ensureOwner($produto);

        return view('produtos.edit', compact('produto'));
    }

    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        $this->ensureOwner($produto);

        $payload = $request->validated();

        $cepData = $this->fetchCepData($payload['cep'] ?? '');
        if ($cepData) {
            $payload['cep_api'] = $cepData;
            $payload['bairro'] = $cepData['bairro'] ?? $payload['bairro'];
            $payload['logradouro'] = $cepData['logradouro'] ?? $produto->logradouro;
            $payload['cidade'] = $cepData['localidade'] ?? $produto->cidade;
            $payload['uf'] = $cepData['uf'] ?? $produto->uf;
        }

        $produto->update($payload);
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto)
    {
        $this->ensureOwner($produto);

        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto removido com sucesso.');
    
    }

    private function ensureOwner(Produto $produto): void
    {
        if ($produto->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }
    }

    #api cep
    private function fetchCepData(string $cep): ?array
    {
        $cepDigits = preg_replace('/\D+/', '', $cep) ?? '';
        if (strlen($cepDigits) !== 8) {
            return null;
        }

        $url = "https://viacep.com.br/ws/{$cepDigits}/json/";

        try {
            $response = Http::timeout(5)->get($url);
            if (!$response->ok()) {
                return null;
            }

            $data = $response->json();

            
            if (is_array($data) && !empty($data['erro'])) {
                return null;
            }

            return is_array($data) ? $data : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

}
