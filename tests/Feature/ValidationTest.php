<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Middleware\ValidateContentMiddleware;
use App\Http\Middleware\ValidateIssuer;
use App\Http\Middleware\ValidateRecipient;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    private const ERR_RESPONSE_STATUS = 200;

    #[DataProvider('failedIssuerDataProvider')]
    public function testFailedIssuer(string $input, array $expectedResponse): void
    {
        $file = UploadedFile::fake()->createWithContent('request.json', $input);
        $actualResponse = $this->post('/api/', [
            'file' => $file,
        ]);
        $actualResponse->assertContent(json_encode(['data' => $expectedResponse]));
        $actualResponse->assertStatus(self::ERR_RESPONSE_STATUS);
    }

    #[DataProvider('failedRecipientDataProvider')]
    public function testFailedRecipient(string $input, array $expectedResponse): void
    {
        $file = UploadedFile::fake()->createWithContent('request.json', $input);
        $actualResponse = $this->post('/api/', [
            'file' => $file,
        ]);
        $actualResponse->assertContent(json_encode(['data' => $expectedResponse]));
        $actualResponse->assertStatus(self::ERR_RESPONSE_STATUS);
    }

    public function testNoFile(): void
    {
        $actualResponse = $this->post('/api/');
        $actualResponse->assertContent(json_encode(['data' => [
            'issuer' => null,
            'result' => ValidateContentMiddleware::ERROR_CODE_VALUE,
        ]]));
        $actualResponse->assertStatus(self::ERR_RESPONSE_STATUS);
    }

    public static function failedIssuerDataProvider(): array
    {
        return self::configureDataProvider(__DIR__ . '/failed_inputs/issuer_inputs.json', ValidateIssuer::ERROR_CODE_VALUE);
    }

    public static function failedRecipientDataProvider(): array
    {
        return self::configureDataProvider(__DIR__ . '/failed_inputs/recipient_inputs.json', ValidateRecipient::ERROR_CODE_VALUE);
    }

    private static function configureDataProvider(string $filepath, string $responseCode): array
    {
        $failedInputs = json_decode(file_get_contents($filepath), true);
        $dataProvider = [];
        foreach ($failedInputs as $failedInput) {
            $dataProvider[] = [
                json_encode($failedInput),
                [
                    'issuer' => $failedInput['data']['issuer']['name'],
                    'result' => $responseCode,
                ],
            ];
        }

        return $dataProvider;
    }
}
