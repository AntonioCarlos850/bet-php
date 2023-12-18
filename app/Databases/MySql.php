<?php

namespace App\Databases;

use App\Interfaces\Database;
use PDO;

final class MySql implements Database
{
    public static $MYSQL_HOST = 'mysql';
    public static $MYSQL_PORT = 3306;
    public static $MYSQL_USER = 'root';
    public static $MYSQL_PASSWORD = 'root';
    public static $MYSQL_DATABASE = 'test';
    public static $con;

    public static function getConnection(): PDO
    {
        if (is_null(self::$con)) {
            self::$con = new PDO(
                'mysql:host=' . self::$MYSQL_HOST . ';port=' . self::$MYSQL_PORT . ';dbname=' . self::$MYSQL_DATABASE,
                self::$MYSQL_USER,
                self::$MYSQL_PASSWORD
            );

            self::$con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$con;
    }
}