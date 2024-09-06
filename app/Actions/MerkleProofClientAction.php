<?php

declare(strict_types=1);

namespace App\Actions;

use App\Exceptions\APIConnectionException;
use Illuminate\Support\Facades\Http;

class MerkleProofClientAction
{
    public function __invoke(array $data): string
    {
        $response = Http::post(config('api.merkle_hasher'), $data);
        if (!$response->successful()) {
            throw new APIConnectionException();
        }

        return $response->json();
    }
}
