<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\ReadFileAction;
use App\DTO\DataDTO;
use App\DTO\Response\ResponseDTO;
use App\DTO\SignatureDTO;
use App\Http\Resources\ResponseResource;
use App\Models\Verification;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class ValidateContentMiddleware extends BaseMiddleware
{
    public const ERROR_CODE_VALUE = 'invalid_content';

    public function __construct(private readonly ReadFileAction    $readFileAction)
    {
    }

    public function handle(Request $request, Closure $next): JsonResource|Response
    {
        $file = $request->file('file');
        $issuerDTO = null;
        $recipientDTO = null;
        if ($file instanceof UploadedFile) {
            $content = ($this->readFileAction)($file);
            $dataDTO = isset($content['data']) && is_array($content['data'])
                ? DataDTO::builder()->fromArray($content['data'])
                : null;

            $signatureDTO = isset($content['signature']) && is_array($content['signature'])
                ? SignatureDTO::builder()->fromArray($content['signature'])
                : null;

            $issuerDTO = $dataDTO->getIssuerDTO();
            $recipientDTO = $dataDTO->getRecipientDTO();

            if ($content['data']) {
                $request->attributes->set(self::DATA_CONTENT_FIELD, $dataDTO);
                $request->attributes->set(self::SIGNATURE_CONTENT_FIELD, $signatureDTO);
                $request->merge([
                    self::DATA_CONTENT_FIELD => $content['data'],
                    self::SIGNATURE_CONTENT_FIELD => $content['signature'] ?? null,
                ]);

                return $next($request);
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
