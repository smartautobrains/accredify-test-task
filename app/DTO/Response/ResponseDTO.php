<?php

declare(strict_types=1);

namespace App\DTO\Response;

readonly class ResponseDTO
{
    public function __construct(
        private ?string $issuer,
        private ?string $result
    )
    {
    }

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function all(): array
    {
        return get_object_vars($this);
    }

    public function toArray(): array
    {
        return $this->all();
    }
}
