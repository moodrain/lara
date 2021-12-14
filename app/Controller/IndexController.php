<?php

namespace App\Controller;

use App\Model\Article;

class IndexController extends Controller
{
    public function index()
    {
        validate([
            'id' => 'nullable|int|min:1',
            'age' => 'nullable|int|min:1|max:199',
        ]);
        return 'Hello ' . config('app_name');
    }

    public function article()
    {
        return rsOk(paginate(Article::query()));
    }
}
