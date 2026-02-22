<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeviAuthorizeService
{
    private const URL = 'https://util.devi.tools/api/v2/authorize';

    /**
     * @return array{ok:bool, message:?string, payload:?array}
     */
    public function check(): array
    {
        try {
            $response = Http::acceptJson()
                ->timeout(5)
                ->get(self::URL);

            $data = $response->json();

            if (!is_array($data)) {
                return [
                    'ok' => false,
                    'message' => 'Falha ao autorizar a operação (resposta inválida do serviço).',
                    'payload' => null,
                ];
            }

            if (($data['status'] ?? null) === 'fail') {
                return [
                    'ok' => false,
                    'message' => $data['message'] ?? 'Operação não autorizada pelo serviço externo.',
                    'payload' => $data,
                ];
            }

            return [
                'ok' => true,
                'message' => null,
                'payload' => $data,
            ];
        } catch (\Throwable $e) {
            return [
                'ok' => false,
                'message' => 'Não foi possível validar a autorização no serviço externo. Tente novamente.',
                'payload' => null,
            ];
        }
    }
}
