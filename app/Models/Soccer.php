<?php

namespace App\Models;

use App\Interfaces\Game;

class Soccer implements Game
{
    public function __construct(
        public string $name,
        private int $id,
        protected string $result = '0-0'
    ) {
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}