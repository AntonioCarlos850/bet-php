<?php

namespace App\Databases;

use App\Interfaces\Database;
use PDO;

final class SQLite implements Database
{
    public static $con;

    public static function getConnection(): PDO
    {
        if (is_null(self::$con)) {
            self::$con = new PDO('sqlite:' . __DIR__ . '../../database.sq3');

            self::$con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$con;
    }
}