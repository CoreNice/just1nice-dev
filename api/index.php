<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$tmpStorage = '/tmp/storage';
$tmpCache = '/tmp/bootstrap/cache';

$directories = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/cache',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/logs',
    $tmpCache
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

putenv('APP_SERVICES_CACHE=' . $tmpCache . '/services.php');
putenv('APP_PACKAGES_CACHE=' . $tmpCache . '/packages.php');
putenv('APP_CONFIG_CACHE=' . $tmpCache . '/config.php');
putenv('APP_ROUTES_CACHE=' . $tmpCache . '/routes.php');
putenv('APP_EVENTS_CACHE=' . $tmpCache . '/events.php');
putenv('VIEW_COMPILED_PATH=' . $tmpStorage . '/framework/views');

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->useStoragePath($_ENV['APP_STORAGE'] ?? $tmpStorage);

$app->handleRequest(Request::capture());
