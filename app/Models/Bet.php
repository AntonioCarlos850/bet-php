<?php

namespace App\Models;

use App\Interfaces\Game;

class Bet
{
    protected array $games = [];
    protected int $value;
    public function __construct(
        float $value,
        protected float $multiplier,
        private ?int $id = null,
        protected bool $winner = false
    ) {
        $this->value = intval(round($value * 100));
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
        return $this->value / 100;
    }

    public function getId(): float
    {
        return $this->id;
    }

    public function getMultiplier(): float
    {
        return $this->multiplier;
    }
}
