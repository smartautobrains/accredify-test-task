<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\IFaces\IBuilder;
use App\DTO\IdentityProofDTO;

class IdentityProofDTOBuilder implements IBuilder
{
    public function fromArray(array $data): IdentityProofDTO
    {
        return new IdentityProofDTO(
            $data['type'] ?? null,
            $data['key'] ?? null,
            $data['location'] ?? null,
        );
    }
}
