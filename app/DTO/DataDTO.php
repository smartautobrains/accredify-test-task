<?php

declare(strict_types=1);

namespace App\DTO;

use App\Builders\DataDTOBuilder;
use App\DTO\IFaces\BuilderDTO;
use DateTime;

readonly class DataDTO implements BuilderDTO
{
    public function __construct(
        private ?string       $id,
        private ?string       $name,
        private ?RecipientDTO $recipientDTO,
        private ?IssuerDTO    $issuerDTO,
        private ?DateTime     $issued
    )
    {
    }

    public function all(): array
    {
        $vars = get_object_vars($this);
        $vars['recipient'] = $vars['recipientDTO']->all();
        unset($vars['recipientDTO']);
        $vars['issuer'] = $vars['issuerDTO']->all();
        unset($vars['issuerDTO']);
        $vars['issued'] = $vars['issued']->format('Y-m-d\TH:i:sP');

        return $vars;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getRecipientDTO(): ?RecipientDTO
    {
        return $this->recipientDTO;
    }

    public function getIssuerDTO(): ?IssuerDTO
    {
        return $this->issuerDTO;
    }

    public function getIssued(): ?DateTime
    {
        return $this->issued;
    }

    public static function builder(): DataDTOBuilder
    {
        return new DataDTOBuilder();
    }
}
