<?php

declare(strict_types=1);

namespace App\DTO\IFaces;

use App\Builders\IFaces\IBuilder;

interface BuilderDTO
{
    public static function builder(): IBuilder;
}
