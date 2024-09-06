<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Middleware\BaseMiddleware;
use Illuminate\Foundation\Http\FormRequest;

class IssuerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            BaseMiddleware::DATA_CONTENT_FIELD . '.issuer.name' => ['required', 'string'],
            BaseMiddleware::DATA_CONTENT_FIELD . '.issuer.identityProof.type' => ['required', 'string'],
            BaseMiddleware::DATA_CONTENT_FIELD . '.issuer.identityProof.key' => ['required', 'string'],
            BaseMiddleware::DATA_CONTENT_FIELD . '.issuer.identityProof.location' => ['required', 'string'],
        ];
    }
}
