<?php
spl_autoload_register('my_autoloader');

function my_autoloader($className)
{
    $pathToClass = __DIR__ . '/'. str_replace("\\", "/", $className . '.php');

    if (file_exists($pathToClass)) {
        require_once $pathToClass;
    }

}
