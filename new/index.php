<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../');
require_once '/app/init.php';

class HelloWorld {

    private function sayHelloTo($name) {
        return 'Hello ' . $name;
    }
}

$app = new \Core\App();
