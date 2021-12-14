<?php

namespace App\Model;

use DateTimeInterface;
use \Illuminate\Database\Eloquent\Model as LaravelModel;

class Model extends LaravelModel
{
    protected $guarded = [];
    protected $perPage = 20;

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}