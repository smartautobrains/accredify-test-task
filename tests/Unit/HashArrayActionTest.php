<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\HashArrayAction;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class HashArrayActionTest extends TestCase
{
    #[DataProvider('successfulDataProvider')]
    public function testSuccessfulAction(array $data, array $expected): void
    {
        $action = $this->app->make(HashArrayAction::class);
        $actual = $action($data);
        $this->assertSame($expected, $actual);
    }

    #[DataProvider('failedDataProvider')]
    public function testFailedAction(array $data, array $expected): void
    {
        $action = $this->app->make(HashArrayAction::class);
        $actual = $action($data);
        $this->assertNotSame($expected, $actual);
    }

    public static function successfulDataProvider() {
        return [
            [
                [
                    'field1' => 'value1',
                    'field2' => 'value2',
                    'field3' => 'value3',
                    'field4' => 'value4',
                ],
                [
                    '0a975962a1969b8a92dadedfb3bac9969e860ba16a6bd0d92f2a5ac1e5ca8cdb',
                    '9e1f68ee5db310972377dcc7f08c78911fdeca23ef2edb8511b0b0848d05faa4',
                    'a5621054a053ed87b8831c169e6e82963b48322d4ef5f51c69dff1ed6a6b0374',
                    'd6bb7b579925baa4fe1cec41152b6577003e6a9fde6850321e36ad4ac9b3f30a',
                ],
            ],
            [
                [
                    'field4' => 'value4',
                    'field3' => 'value3',
                    'field2' => 'value2',
                    'field1' => 'value1',
                ],
                [
                    '0a975962a1969b8a92dadedfb3bac9969e860ba16a6bd0d92f2a5ac1e5ca8cdb',
                    '9e1f68ee5db310972377dcc7f08c78911fdeca23ef2edb8511b0b0848d05faa4',
                    'a5621054a053ed87b8831c169e6e82963b48322d4ef5f51c69dff1ed6a6b0374',
                    'd6bb7b579925baa4fe1cec41152b6577003e6a9fde6850321e36ad4ac9b3f30a',
                ],
            ],
            [
                [
                    'field3' => 'value3',
                    'field2' => 'value2',
                    'field1' => 'value1',
                    'field4' => 'value4',
                ],
                [
                    '0a975962a1969b8a92dadedfb3bac9969e860ba16a6bd0d92f2a5ac1e5ca8cdb',
                    '9e1f68ee5db310972377dcc7f08c78911fdeca23ef2edb8511b0b0848d05faa4',
                    'a5621054a053ed87b8831c169e6e82963b48322d4ef5f51c69dff1ed6a6b0374',
                    'd6bb7b579925baa4fe1cec41152b6577003e6a9fde6850321e36ad4ac9b3f30a',
                ],
            ],
        ];
    }

    public static function failedDataProvider() {
        return [
            [
                [
                    'field2' => 'value1',
                    'field1' => 'value2',
                    'field3' => 'value3',
                    'field4' => 'value4',
                ],
                [
                    '0a975962a1969b8a92dadedfb3bac9969e860ba16a6bd0d92f2a5ac1e5ca8cdb',
                    '9e1f68ee5db310972377dcc7f08c78911fdeca23ef2edb8511b0b0848d05faa4',
                    'a5621054a053ed87b8831c169e6e82963b48322d4ef5f51c69dff1ed6a6b0374',
                    'd6bb7b579925baa4fe1cec41152b6577003e6a9fde6850321e36ad4ac9b3f30a',
                ],
            ],
            [
                [
                    'field4' => 'value4',
                    'field3' => 'value3',
                    'field2' => 'value2',
                    'field1' => 'value1',
                ],
                [
                    '9e1f68ee5db310972377dcc7f08c78911fdeca23ef2edb8511b0b0848d05faa4',
                    '0a975962a1969b8a92dadedfb3bac9969e860ba16a6bd0d92f2a5ac1e5ca8cdb',
                    'a5621054a053ed87b8831c169e6e82963b48322d4ef5f51c69dff1ed6a6b0374',
                    'd6bb7b579925baa4fe1cec41152b6577003e6a9fde6850321e36ad4ac9b3f30a',
                ],
            ],
            [
                [
                    'field3' => 'value3',
                    'field2' => 'value2',
                    'field1' => 'value1',
                    'field4' => 'value4',
                ],
                [
                    '0a975962a1969b8a92dadedfb3bac9969e860ba16a6bd0d92f2a5ac1e5ca8cdb',
                    '9e1f68ee5db310972377dcc7f08c78911fdeca23ef2edb8511b0b0848d05faa4',
                    'a5621054a053ed87b8831c169e6e82963b48322d4ef5f51c69dff1ed6a6b0374',
                ],
            ],
        ];
    }
}
