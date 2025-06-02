<?php
require_once __DIR__ . '/vendor/autoload.php';

// Optional: load dev.env config
$envFile = __DIR__ . '/config/dev.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        putenv(trim($line));
    }
}
