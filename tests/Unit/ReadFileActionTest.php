<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\ReadFileAction;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ReadFileActionTest extends TestCase
{
    #[DataProvider('successfulDataProvider')]
    public function testSuccessfulAction(string $content, array $expected): void
    {
        $action = $this->app->make(ReadFileAction::class);
        $file = UploadedFile::fake()->createWithContent('request.json', $content);
        $actual = $action($file);
        $this->assertSame($expected, $actual);
    }

    #[DataProvider('failedDataProvider')]
    public function testFailedAction(string $content, array $expected): void
    {
        $action = $this->app->make(ReadFileAction::class);
        $file = UploadedFile::fake()->createWithContent('request.json', $content);
        $actual = $action($file);
        $this->assertNotSame($expected, $actual);
    }

    public static function successfulDataProvider(): array
    {
        return [
            [
                '{"data": "data_value"}',
                ['data' => 'data_value'],
            ],
            [
                '{"data":{"recipient":{"name":"Marty McFly"},"issuer":null}}',
                [
                    'data' => [
                        'recipient' => [
                            'name' => 'Marty McFly',
                        ],
                        'issuer' => null,
                    ],
                ],
            ],
        ];
    }

    public static function failedDataProvider(): array
    {
        return [
            [
                '{"data": "data_value"}',
                ['data' => 'data_value1'],
            ],
            [
                '{"data":{"recipient":{"name":"Marty McFly"},"issuer":"a"}}',
                [
                    'data' => [
                        'recipient' => [
                            'name' => 'Marty McFly',
                        ],
                        'issuer' => null,
                    ],
                ],
            ],
        ];
    }
}
