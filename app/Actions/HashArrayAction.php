<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Http\Resources\Json\JsonResource;

class HashArrayAction
{
    public function __invoke(array $data): array
    {
        $flattenedArray = $this->flattenArray($data);

        $hashedArray = [];
        foreach ($flattenedArray as $field => $value) {
            $resource = new JsonResource(([$field => $value]));
            $hashedArray[] = hash('sha256', $resource->toJson());
        }
        sort($hashedArray);

        return $hashedArray;
    }

    private function flattenArray(array $array, string $prefix = ''): array
    {
        $flatArray = [];

        foreach ($array as $key => $value) {
            $newKey = $prefix === '' ? $key : $prefix . '.' . $key;
            if (is_array($value)) {
                $flatArray += $this->flattenArray($value, $newKey);
            } else {
                $flatArray[$newKey] = $value;
            }
        }

        return $flatArray;
    }
}
