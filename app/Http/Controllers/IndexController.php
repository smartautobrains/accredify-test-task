<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\Response\ResponseDTO;
use App\Http\Middleware\BaseMiddleware;
use App\Http\Resources\ResponseResource;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexController extends Controller
{
    public const RESPONSE_CODE = 'verified';

    public function __construct()
    {
    }

    public function __invoke(Request $request): JsonResource
    {
        $dataDTO = $request->attributes->get(BaseMiddleware::DATA_CONTENT_FIELD);
        $responseDTO = new ResponseDTO(
            $dataDTO->getIssuerDTO()?->getName(),
            self::RESPONSE_CODE,
        );
        $responseResource = new ResponseResource($responseDTO);

        $verification = new Verification([
            Verification::PROPERTY_USER_NAME => $dataDTO->getRecipientDTO()?->getName(),
            Verification::PROPERTY_FILE_TYPE => 'json',
            Verification::PROPERTY_RESULT => $responseResource->toJson(),
        ]);
        $verification->save();

        return $responseResource;
    }
}
