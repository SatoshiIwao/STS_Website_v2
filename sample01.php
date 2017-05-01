<?php
require_once "vendor/autoload.php";
use Myapp\Foo;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name');
$log->pushHandler(new StreamHandler("php://stdout", Logger::WARNING));
$log->addWarning('Foo');

$foo = new Foo;

echo $foo->foo();
