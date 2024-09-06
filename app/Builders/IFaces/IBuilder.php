<?php

declare(strict_types=1);

namespace App\Builders\IFaces;

use App\DTO\IFaces\BuilderDTO;

interface IBuilder
{
    public function fromArray(array $data): BuilderDTO;
}
