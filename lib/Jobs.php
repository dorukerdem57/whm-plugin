<?php
namespace WHMWPManager\Lib;

class Jobs
{
    public static function add(string $type, array $payload): void
    {
        $db = Db::conn();
        $db->exec('CREATE TABLE IF NOT EXISTS jobs (id INTEGER PRIMARY KEY, type TEXT, payload TEXT, created_at INTEGER)');
        $stmt = $db->prepare('INSERT INTO jobs(type, payload, created_at) VALUES (:type, :payload, :created_at)');
        $stmt->execute([
            ':type' => $type,
            ':payload' => json_encode($payload),
            ':created_at' => time(),
        ]);
    }
}
