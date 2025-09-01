<?php
require_once __DIR__ . '/bootstrap.php';

$path = $_GET['route'] ?? 'dashboard';
$viewFile = __DIR__ . '/views/' . basename($path) . '.php';
if (!file_exists($viewFile)) {
    $viewFile = __DIR__ . '/views/dashboard.php';
}
$view = $viewFile;
include __DIR__ . '/views/layout.php';
