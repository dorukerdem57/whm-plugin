<?php
namespace WHMWPManager\Lib;

class Validator
{
    public static function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}
