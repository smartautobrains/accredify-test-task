<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\DTO\Response\ResponseDTO;
use App\Http\Requests\RecipientRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Verification;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ValidateRecipient extends BaseMiddleware
{
    public const ERROR_CODE_VALUE = 'invalid_recipient';

    public function __construct()
    {
    }

    public function handle(Request $request, Closure $next): JsonResource|Response
    {
        $validator = Validator::make($request->all(), (new RecipientRequest())->rules());
        $data = $request->attributes->get(self::DATA_CONTENT_FIELD);
        if (!$data || $validator->fails()) {
            $issuerDTO = $data->getIssuerDTO();
            $recipientDTO = $data->getRecipientDTO();
            $responseDTO = new ResponseDTO(
                $issuerDTO?->getName(),
                self::ERROR_CODE_VALUE,
            );
            $responseResource = new ResponseResource($responseDTO);

            $verification = new Verification([
                Verification::PROPERTY_USER_NAME => $recipientDTO?->getName(),
                Verification::PROPERTY_FILE_TYPE => 'json',
                Verification::PROPERTY_RESULT => $responseResource->toJson(),
            ]);
            $verification->save();

            return $responseResource;
        }

        return $next($request);
    }
}
