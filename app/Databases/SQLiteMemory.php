<?php

namespace App\Databases;

use App\Interfaces\Database;
use PDO;

final class SQLiteMemory implements Database
{
    public static $con;

    public static function getConnection(): PDO
    {
        if (is_null(self::$con)) {
            self::$con = new PDO('sqlite::memory:');

            self::$con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$con;
    }
}