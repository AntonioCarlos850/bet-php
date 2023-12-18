<?php

namespace App\Interfaces;

use PDO;

interface Database
{
    public static function getConnection(): PDO;
}