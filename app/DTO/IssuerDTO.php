<?php

declare(strict_types=1);

namespace App\DTO;

use App\Builders\IssuerDTOBuilder;
use App\DTO\IFaces\BuilderDTO;

readonly class IssuerDTO implements BuilderDTO
{
    public function __construct(
        private ?string           $name,
        private ?IdentityProofDTO $identityProofDTO
    )
    {
    }

    public function all(): array
    {
        $vars = get_object_vars($this);
        $vars['identityProof'] = $vars['identityProofDTO']->all();
        unset($vars['identityProofDTO']);

        return $vars;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getIdentityProofDTO(): ?IdentityProofDTO
    {
        return $this->identityProofDTO;
    }

    public static function builder(): IssuerDTOBuilder
    {
        return new IssuerDTOBuilder();
    }
}
