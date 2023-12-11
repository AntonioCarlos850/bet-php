<?php

namespace Models;

use Interfaces\Game;

class Soccer implements Game
{
    protected string $result = '0-0';

    public function __construct(public string $name, private int $id)
    {
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getId(): int
    {
        return $this->id;
    }
}