<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\HashArrayAction;
use App\Actions\MerkleProofClientAction;
use App\DTO\Response\ResponseDTO;
use App\Exceptions\InvalidSignatureException;
use App\Http\Requests\SignatureRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Verification;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ValidateSignature extends BaseMiddleware
{
    public const ERROR_CODE_VALUE = 'invalid_signature';

    public function __construct(
        private readonly HashArrayAction         $hashArrayAction,
        private readonly MerkleProofClientAction $merkleProofClientAction
    )
    {
    }

    public function handle(Request $request, Closure $next): JsonResource|Response
    {
        $dataDTO = $request->attributes->get(self::DATA_CONTENT_FIELD);
        $signatureDTO = $request->attributes->get(self::SIGNATURE_CONTENT_FIELD);
        $validator = Validator::make($request->all(), (new SignatureRequest())->rules());
        $issuerDTO = $dataDTO->getIssuerDTO();
        $recipientDTO = $dataDTO->getRecipientDTO();
        if (!$validator->fails()) {
            $sha256Array = ($this->hashArrayAction)($dataDTO->all());
            try {
                $proofHash = ($this->merkleProofClientAction)($sha256Array);
                if ($proofHash !== $signatureDTO?->getTargetHash()) {
                    throw new InvalidSignatureException();
                }

                return $next($request);
            } catch (Exception $exception) {
            }
        }

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
}
