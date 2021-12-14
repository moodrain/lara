<?php

require __DIR__ . '/../vendor/autoload.php';
require  __DIR__ . '/../config/config.php';

$dbManager = new Illuminate\Database\Capsule\Manager();

foreach(config('database', []) as $dbConn) {
    $dbManager->addConnection($dbConn);
}
$dbManager->setAsGlobal();
$dbManager->bootEloquent();