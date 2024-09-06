<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\IFaces\IBuilder;
use App\DTO\RecipientDTO;

class RecipientDTOBuilder implements IBuilder
{
    public function fromArray(array $data): RecipientDTO
    {
        return new RecipientDTO(
            $data['name'] ?? null,
            $data['email'] ?? null,
        );
    }
}
