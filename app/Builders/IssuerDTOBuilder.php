<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\IFaces\IBuilder;
use App\DTO\IdentityProofDTO;
use App\DTO\IssuerDTO;

class IssuerDTOBuilder implements IBuilder
{
    public function fromArray(array $data): IssuerDTO
    {
        return new IssuerDTO(
            $data['name'] ?? null,
            isset($data['identityProof'])
                ? IdentityProofDTO::builder()->fromArray($data['identityProof'])
                : null,
        );
    }
}
