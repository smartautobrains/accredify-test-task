<?php

declare(strict_types=1);

namespace App\DTO;

use App\Builders\RecipientDTOBuilder;
use App\DTO\IFaces\BuilderDTO;

readonly class RecipientDTO implements BuilderDTO
{
    public function __construct(
        private ?string $name,
        private ?string $email
    )
    {
    }

    public function all(): array
    {
        return get_object_vars($this);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public static function builder(): RecipientDTOBuilder
    {
        return new RecipientDTOBuilder();
    }
}
