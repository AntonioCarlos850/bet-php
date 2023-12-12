<?php

namespace App\Interfaces;

interface Game
{
    public function setResult($result);
    public function getResult();
    public function getId(): int;
}