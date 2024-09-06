<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Http\UploadedFile;

class ReadFileAction
{
    public function __invoke(UploadedFile $file, ?string $field = null): ?array
    {
        return json_decode($file->getContent(), true);
    }
}
