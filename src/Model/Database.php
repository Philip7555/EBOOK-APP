<?php

class Database
{
    private static ?\PDO $pdo = null;

    public static function getConnection(): \PDO
    {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../config.php';
            $path = $config['db_path'];

            self::$pdo = new \PDO('sqlite:' . $path);
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }
}