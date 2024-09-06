<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Middleware\BaseMiddleware;
use Illuminate\Foundation\Http\FormRequest;

class SignatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            BaseMiddleware::SIGNATURE_CONTENT_FIELD . '.type' => ['required', 'string'],
            BaseMiddleware::SIGNATURE_CONTENT_FIELD . '.targetHash' => ['required', 'string'],
        ];
    }
}
