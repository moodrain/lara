<?php

require __DIR__ . '/../bootstrap/cli.php';

use \Illuminate\Database\Capsule\Manager;
use \Illuminate\Database\Schema\Blueprint;

$db = Manager::connection();
$builder = $db->getSchemaBuilder();

$createIfNotExists = function($table, $create) use ($builder) {
    if ($builder->hasTable($table)) {
        echo 'table ' . $table . ' already exist !' . PHP_EOL;
    } else {
        $builder->create($table, $create);
        echo 'table ' . $table . ' created' . PHP_EOL;
    }
};

$createIfNotExists('users', function(Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('name');
    $table->string('email');
    $table->string('password');
    $table->timestamps();
});

$createIfNotExists('articles', function(Blueprint $table) {
    $table->bigIncrements('id');
    $table->bigInteger('user_id');
    $table->string('title');
    $table->text('content');
    $table->timestamps();
});
