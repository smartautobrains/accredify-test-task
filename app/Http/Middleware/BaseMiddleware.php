<?php

declare(strict_types=1);

namespace App\Http\Middleware;

abstract class BaseMiddleware
{
    public const DATA_CONTENT_FIELD = 'data';

    public const SIGNATURE_CONTENT_FIELD = 'signature';
}
