<?php

namespace Tests\Unit\Services;

use App\Models\Bet;
use App\Models\Soccer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use App\Services\AnalyzeResultsService;

final class AnalyzeResultsTest extends TestCase
{
    public static function provideWinnerBetAndGames(): array
    {
        $games = [];
        $bet = new Bet(150.55, 1.2);
        for ($i=0; $i < 5; $i++) {
            $game = new Soccer(random_bytes(5), rand(0, 5));
            $game->setResult(rand(0, 10) . '-' . rand(0, 10));
            $bet->addGame($game);
            $games[] = $game;
        }

        return [
            'winner bet' => [$bet, $games]
        ];
    }

    public static function provideNotWinnerBetAndGames(): array
    {
        $games = [];
        $bet = new Bet(150.55, 1.2);
        for ($i=0; $i < 5; $i++) {
            $game = new Soccer(random_bytes(5), rand(0, 5));
            $game->setResult(rand(0, 4) . '-' . rand(0, 4));
            $bet->addGame($game);

            $game = clone $game;
            $game->setResult(rand(5, 10) . '-' . rand(5, 10));
            $games[] = $game;
        }

        return [
            'not winner bet' => [$bet, $games]
        ];
    }

    public static function provideInvalidInput(): array
    {
        $games = [];
        $bet = new Bet(150.55, 1.2);
        for ($i=0; $i < 5; $i++) {
            $game = new Soccer(random_bytes(5), rand(0, 5));
            $bet->addGame($game);
        }

        for ($i=0; $i < 4; $i++) {
            $game = new Soccer(random_bytes(5), rand(0, 5));
            $games[] = $game;
        }

        return [
            'invalid input' => [$bet, $games]
        ];
    }

    #[DataProvider('provideWinnerBetAndGames')]
    #[DataProvider('provideNotWinnerBetAndGames')]
    public function testValidInput(Bet $bet, array $games): void
    {
        $service = new AnalyzeResultsService($bet, $games);

        $this->assertIsObject($service);
    }

    #[DataProvider('provideInvalidInput')]
    public function testInvalidInput(Bet $bet, array $games): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Number of games passed and bet games is different');
        new AnalyzeResultsService($bet, $games);
    }

    #[DataProvider('provideWinnerBetAndGames')]
    public function testWinnerBet(Bet $bet, array $games): void
    {
        $service = new AnalyzeResultsService($bet, $games);

        $this->assertTrue($service->verifyBet()->getResult());
    }

    #[DataProvider('provideNotWinnerBetAndGames')]
    public function testNotWinnerBet(Bet $bet, array $games): void
    {
        $service = new AnalyzeResultsService($bet, $games);

        $this->assertFalse($service->verifyBet()->getResult());
    }
}