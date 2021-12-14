<?php

namespace App\Util;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\MessageBag;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory;

class Validator
{
    /* @var Factory */
    static $factory;
    static $messageList;
    /* @var Manager */
    static $dbManager;
    static $errHandler;

    /* @var MessageBag */
    private $messages = [];

    public static function init(Manager $dbManager, $langFilePath)
    {
        self::$dbManager = $dbManager;
        if (!self::$factory) {
            $filesystem = new Filesystem();
            $fileLoader = new FileLoader($filesystem, $langFilePath);
            $translator = new Translator($fileLoader, 'zh');
            self::$factory = new Factory($translator);
            self::$messageList = require_once ($langFilePath . '/zh/validation.php');
        }
    }

    public static function setErrHandler(\Closure $handler)
    {
        self::$errHandler = $handler;
    }

    public function __construct(MessageBag $messages)
    {
        $this->messages = $messages;
    }

    public static function make($data, $rules, $runHandler = true)
    {
        $validator = self::$factory->make($data, $rules, self::$messageList);
        $validator->setPresenceVerifier(new DatabasePresenceVerifier(self::$dbManager->getDatabaseManager()));
        $errors = $validator->errors();
        if ($runHandler && $errors->isNotEmpty() && self::$errHandler) {
            $callback = self::$errHandler;
            $callback($errors);
            return null;
        }
        return $errors->isNotEmpty() ? (new Validator($errors)) : null;
    }

    public function msg()
    {
        return $this->messages->first();
    }

    public function messages()
    {
        return $this->messages;
    }

}