<?php

use App\Model\Article;
use App\Model\User;

require __DIR__ . '/../bootstrap/cli.php';

User::query()->truncate();
Article::query()->truncate();

$user = User::query()->create([
    'name' => 'user-1',
    'email' => 'user-1@test.com',
    'password' => password_hash('test', PASSWORD_DEFAULT),
]);

Article::query()->create([
    'user_id' => $user->id,
    'title' => 'article-1',
    'content' => 'content of article-1',
]);

$article = Article::query()->with('user')->first();
dd($article->toArray());