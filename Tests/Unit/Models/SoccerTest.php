<?php

namespace Tests\Unit\Models;

use App\Models\Soccer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class SoccerTest extends TestCase
{
    public static function provideDataToCreate(): array
    {
        $name = random_bytes(10);
        $id = rand();
        $integerResult = rand();
        $stringResult = random_bytes(10);

        return [
            'integer result' => [$name, $id, $integerResult],
            'string result' => [$name, $id, $stringResult],
        ];
    }

    #[DataProvider('provideDataToCreate')]
    public function testCreate(string $name, int $id, mixed $result): void
    {
        $soccer = new Soccer($name, $id);
        $soccer->setResult($result);

        $this->assertEquals($result, $soccer->getResult());
        $this->assertEquals($name, $soccer->getName());
        $this->assertEquals($id, $soccer->getId());
    }
}