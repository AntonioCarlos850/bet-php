<?php

namespace Interfaces;

interface Game
{
    public function setResult($result);
    public function getResult();
    public function getId(): int;
}