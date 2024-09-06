<?php

declare(strict_types=1);

namespace App\DTO;

use App\Builders\IdentityProofDTOBuilder;
use App\DTO\IFaces\BuilderDTO;

readonly class IdentityProofDTO implements BuilderDTO
{
    public function __construct(
        private ?string $type,
        private ?string $key,
        private ?string $location
    )
    {
    }

    public function all(): array
    {
        return get_object_vars($this);
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public static function builder(): IdentityProofDTOBuilder
    {
        return new IdentityProofDTOBuilder();
    }
}
