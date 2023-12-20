<?php

namespace App\Databases;

use App\Interfaces\Database;
use PDO;

class SQLite implements Database
{
    protected static $con;

    public static function getConnection(): PDO
    {
        if (!isset(self::$con)) {
            self::$con = new PDO('sqlite:' . __DIR__ . '../../database.sq3');

            self::$con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$con;
    }
}