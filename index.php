<?php

require_once './lib/global.php';

$controller = null;

$controller = match (lib\get("action")) {
    "get" => new controller\RetrieveImageController(lib\get("id")),
    "add" => new controller\AddController($_POST),
    "delete" => new controller\DeleteController(lib\get("id")),
    default => new controller\IndexController(lib\get('letter')),
};

$controller -> doAction();