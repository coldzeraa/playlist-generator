<?php

spl_autoload_register(function ($class_name) {
    require_once implode("/", explode("_", $class_name)) . ".php";
});


$dispatcher = new Utils_Dispatcher();
$dispatcher->dispatch();
