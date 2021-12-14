<?php

require __DIR__ . '/../bootstrap/cli.php';

use App\Model\Article;
use App\Model\User;
use \Illuminate\Database\Capsule\Manager;

$db = Manager::connection();

throw_unless($db->getSchemaBuilder()->hasTable('users'), 'table users not exists');
throw_unless($db->getSchemaBuilder()->hasTable('articles'), 'table articles not exists');

User::query()->truncate();
Article::query()->truncate();

$user = User::query()->create([
    'name' => 'user-1',
    'email' => 'user-1@test.com',
    'password' => password_hash('test', PASSWORD_DEFAULT),
]);

for ($i = 0; $i < 100; $i++) {
    Article::query()->create([
        'user_id' => $user->id,
        'title' => 'article-' . ($i+1),
        'content' => 'content of article-' . ($i+1),
    ]);
}

echo 'seed complete';
