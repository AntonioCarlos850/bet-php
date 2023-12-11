<?php

namespace Models;

use Interfaces\Game;

class Bet
{ 
    protected array $games = [];
    protected bool $winner = false;
    public function __construct(
        protected float $value, 
        protected float $multiplier
    ) {
    }

    public function addGame(Game $game)
    {
        $this->games[] = $game;
    }

    public function getGames(): array
    {
        return $this->games;
    }

    public function isWinner()
    {
        $this->winner = true;
    }

    public function getResult(): bool
    {
        return $this->winner;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getMultiplier(): float
    {
        return $this->multiplier;
    }
}