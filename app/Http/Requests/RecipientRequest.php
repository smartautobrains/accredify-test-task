<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Middleware\BaseMiddleware;
use Illuminate\Foundation\Http\FormRequest;

class RecipientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            BaseMiddleware::DATA_CONTENT_FIELD . '.recipient.name' => ['required', 'string'],
            BaseMiddleware::DATA_CONTENT_FIELD . '.recipient.email' => ['required', 'email'],
        ];
    }
}
