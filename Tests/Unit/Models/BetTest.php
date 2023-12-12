<?php

namespace App\Tests\Unit\Models;

use App\Models\Bet;
use App\Models\Soccer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class BetTest extends TestCase
{
    public static function provideSoccerGames(): array
    {
        $games = [];
        for ($i=0; $i < 5; $i++) {
            $game = new Soccer(random_bytes(5), rand(0, 5));
            $game->setResult(rand(0, 10) . '-' . rand(0, 10));
            $games[] = $game;
        }

        return [
            '5 soccer games' => [$games, (rand(100, 1000) / 100), (rand(100, 1000) / 100)],
            'empty soccer games' => [[], (rand(100, 1000) / 100), (rand(100, 1000) / 100)]
        ];
    }

    #[DataProvider('provideSoccerGames')]
    public function testGetters(array $games, float $value, float $multiplier): void
    {
        $bet = new Bet($value, $multiplier);
        foreach ($games as $game) {
            $bet->addGame($game);
        }

        $this->assertCount(count($games), $bet->getGames());
        $this->assertEquals($value, $bet->getValue());
        $this->assertEquals($multiplier, $bet->getMultiplier());
    }

    public function testIfBetCanWin(): void
    {
        $bet = new Bet(rand(), rand());
        $bet->isWinner();

        $this->assertTrue($bet->getResult());
    }
}