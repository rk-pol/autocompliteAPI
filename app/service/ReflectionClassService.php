<?php

namespace App\Service;

use ReflectionClass;
use App\Service\HttpStatusCodeService;

class ReflectionClassService
{
    public static function doesMethodHasParameters($className, $methodName)
    {
        $reflectionClass = new ReflectionClass($className);

        return $reflectionClass->getMethod($methodName)->getNumberOfParameters();
    }
}