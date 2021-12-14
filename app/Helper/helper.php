<?php

use Illuminate\Database\Eloquent\Builder;

function dd(...$vars) {
    count($vars) === 1 ? var_dump($vars[0]) : var_dump($vars);
    exit();
}

function config($key, $default = null)
{
    return array_key_exists($key, $GLOBALS['CONFIG']) ? $GLOBALS['CONFIG'][$key] : $default;
}

function rs($data)
{
    header('Content-Type: application/json');
    return json_encode($data, JSON_UNESCAPED_UNICODE);
}

function rsOk($data, $msg = '', $code = 0)
{
    return rs([
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
    ]);
}

function rsErr($msg, $code = '-1', $data = null)
{
    return rs([
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
    ]);
}

function validate($rules, $data = null, $runHandler = true)
{
    return \App\Util\Validator::make($data ?? $_REQUEST, $rules, $runHandler);
}

function paginate(Builder $builder, $page = null, $size = null)
{
    $page = $page ?? $_REQUEST['page'] ?? 1;
    $size = $size ?? $builder->getModel()->getPerPage() ?? 10;
    return $builder->simplePaginate($size, ['*'], 'page', $page);
}