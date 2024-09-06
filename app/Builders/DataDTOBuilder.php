<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\IFaces\IBuilder;
use App\DTO\DataDTO;
use App\DTO\IssuerDTO;
use App\DTO\RecipientDTO;
use DateTime;
use Exception;

class DataDTOBuilder implements IBuilder
{
    public function fromArray(array $data): DataDTO
    {
        try {
            $date = $data['issued'] ? new DateTime($data['issued']) : null;
        } catch (Exception $e) {
            $date = null;
        }

        return new DataDTO(
            $data['id'] ?? null,
            $data['name'] ?? null,
            isset($data['recipient']) && is_array($data['recipient'])
                ? RecipientDTO::builder()->fromArray($data['recipient'])
                : null,
            isset($data['issuer']) && is_array($data['issuer'])
                ? IssuerDTO::builder()->fromArray($data['issuer'])
                : null,
            $date,
        );
    }
}
