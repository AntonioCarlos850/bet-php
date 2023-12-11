<?php

namespace Services;

use Exception;
use Models\Bet;

class AnalyzeResultsService
{
    public function __construct(private Bet $bet, private array $games) {
        $this->validate();
    }

    private function validate(): void
    {
        if (count($this->bet->getGames()) !== count($this->games)) {
            throw new Exception('Number of games passed and bet games is different');
        }
    }
}