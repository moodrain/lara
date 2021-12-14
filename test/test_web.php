<?php

require __DIR__ . '/../bootstrap/cli.php';

$req = new \Muyu\Curl('http://localhost:8000');
echo $req->get();
