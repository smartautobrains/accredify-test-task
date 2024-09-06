<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\DTO\Response\ResponseDTO;
use App\Http\Requests\IssuerRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Verification;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ValidateIssuer extends BaseMiddleware
{
    public const ERROR_CODE_VALUE = 'invalid_issuer';

    public function __construct()
    {
    }

    public function handle(Request $request, Closure $next): JsonResource|Response
    {
        $validator = Validator::make($request->all(), (new IssuerRequest())->rules());
        $dataDTO = $request->attributes->get(self::DATA_CONTENT_FIELD);
        $issuerDTO = $dataDTO->getIssuerDTO();
        if (!$validator->fails()) {
            $location = $issuerDTO->getIdentityProofDTO()?->getLocation();
            if (is_string($location)) {
                try {
                    $dnsRecords = dns_get_record($location, DNS_TXT);
                } catch (Exception $exception) {
                    $dnsRecords = [];
                }

                foreach ($dnsRecords as $record) {
                    if (isset($record['txt']) && str_contains($record['txt'], $issuerDTO->getIdentityProofDTO()?->getKey())) {
                        return $next($request);
                    }
                }
            }
        }
        $responseDTO = new ResponseDTO(
            $issuerDTO?->getName(),
            self::ERROR_CODE_VALUE,
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
