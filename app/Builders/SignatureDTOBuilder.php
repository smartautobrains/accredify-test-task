<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\IFaces\IBuilder;
use App\DTO\SignatureDTO;

class SignatureDTOBuilder implements IBuilder
{
    public function fromArray(array $data): SignatureDTO
    {
        return new SignatureDTO($data['type'] ?? null, $data['targetHash'] ?? null);
    }
}
