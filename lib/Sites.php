<?php
namespace WHMWPManager\Lib;

class Sites
{
    public static function all(): array
    {
        $db = Db::conn();
        $db->exec('CREATE TABLE IF NOT EXISTS sites (id INTEGER PRIMARY KEY, domain TEXT, base_url TEXT, token TEXT)');
        $stmt = $db->query('SELECT * FROM sites');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
