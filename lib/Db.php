<?php
namespace WHMWPManager\Lib;

use PDO;

class Db
{
    private static ?PDO $pdo = null;

    public static function conn(): PDO
    {
        if (!self::$pdo) {
            $dsn = 'sqlite:' . __DIR__ . '/../data/whmwp.sqlite';
            self::$pdo = new PDO($dsn);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }
}
