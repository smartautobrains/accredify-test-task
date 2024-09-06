<?php

declare(strict_types=1);

namespace App\DTO;

use App\Builders\SignatureDTOBuilder;
use App\DTO\IFaces\BuilderDTO;

readonly class SignatureDTO implements BuilderDTO
{
    public function __construct(
        private ?string $type,
        private ?string $targetHash
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

    public function getTargetHash(): ?string
    {
        return $this->targetHash;
    }

    public static function builder(): SignatureDTOBuilder
    {
        return new SignatureDTOBuilder();
    }
}
