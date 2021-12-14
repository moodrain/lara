<?php

use App\Util\Validator;

$dbManager = new Illuminate\Database\Capsule\Manager();

foreach(config('database', []) as $dbConn) {
    $dbManager->addConnection($dbConn);
}
$dbManager->setAsGlobal();
$dbManager->bootEloquent();

Validator::init($dbManager, __DIR__ . '/../resource/lang');
Validator::setErrHandler(function(\Illuminate\Support\MessageBag $messages) {
    echo rsErr($messages->first(), -1, $messages->all());
    exit;
});


$path = explode('?', $_SERVER['REQUEST_URI'])[0];
$path = explode('/', $path);

define('CONTROLLER', !empty($path[1]) ? $path[1] : 'index');
define('ACTION', !empty($path[2]) ? $path[2] : 'index');

$controllerName = 'App\\Controller\\' . ucfirst(CONTROLLER) . 'Controller';
$actionName = ACTION;
$controller = new $controllerName;
echo $controller->$actionName();
