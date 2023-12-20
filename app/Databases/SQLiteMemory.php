<?php

namespace App\Databases;

use App\Interfaces\Database;
use PDO;

class SQLiteMemory implements Database
{
    public static \PDO $con;

    public static function getConnection(): PDO
    {
        if (!isset(self::$con)) {
            self::$con = new PDO('sqlite::memory:');

            self::$con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$con;
    }
}