<?php

namespace App\Services;

use App\DAOs\Bet as DAOsBet;
use Exception;
use App\Models\Bet;
use BadMethodCallException;

class AnalyzeResultsService
{
    public function __construct(
        private Bet $bet,
        private array $games,
        private DAOsBet $dao
    ) {
        $this->validateInput();
    }

    private function validateInput(): void
    {
        if (count($this->bet->getGames()) !== count($this->games)) {
            throw new \BadMethodCallException('Number of games passed and bet games is different');
        }
    }

    public function verifyBet(): Bet
    {
        if ($this->countBetWinningGames() === count($this->bet->getGames())) {
            $this->bet->isWinner();
            $this->dao->update($this->bet);
        }

        return $this->bet;
    }

    public function getBet(): Bet
    {
        return $this->bet;
    }

    private function countBetWinningGames(): int
    {
        $i = 0;
        foreach ($this->games as $game) {
            foreach ($this->bet->getGames() as $betGame) {
                if (
                    $betGame->getId() === $game->getId()
                    && $betGame->getResult() === $game->getResult()
                ) {
                    $i++;
                }
            }
        }

        return $i;
    }
}