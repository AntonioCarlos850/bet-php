<?php

namespace App\Databases;

use App\Interfaces\Database;
use PDO;

class MySql implements Database
{
    // This isn't a good practice, use environment variables
    const MYSQL_HOST = 'mysql';
    const MYSQL_PORT = 3306;
    const MYSQL_USER = 'root';
    const MYSQL_PASSWORD = 'root';
    const MYSQL_DATABASE = 'test';
    protected static $con;

    public static function getConnection(): PDO
    {
        if (!isset(self::$con)) {
            self::$con = new PDO(
                'mysql:host=' . self::MYSQL_HOST . ';port=' . self::MYSQL_PORT . ';dbname=' . self::MYSQL_DATABASE,
                self::MYSQL_USER,
                self::MYSQL_PASSWORD
            );

            self::$con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$con;
    }
}