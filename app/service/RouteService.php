<?php
namespace App\Service;

use App\Service\HttpStatusCodeService;

class RouteService
{
    private $routes = [];
    private $httpMethods = ['GET', 'POST', 'DELETE', 'PUT'];

    private function httpMethodIsAllowed($httpMethod)
    {
        return in_array(strtoupper($httpMethod), $this->httpMethods);
    }

    private function checkClassInfo($classInfo)
    {
        $classPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $classInfo[0] . '.php';
        $classPath = str_replace('\\', '/', $classPath);

        if (!file_exists($classPath)) {
            return false;
        }

        require_once $classPath;
        $classSegments = explode('\\', $classInfo[0]);
        $className = end($classSegments);

        if (!class_exists($className)) {
            return false;
        }

        $classObj = new $className();

        if (!method_exists($classObj, $classInfo[1])) {
            return false;
        }

        return true;
    }

    private function routeIsMatched($uri)
    {
        return isset($this->routes[$uri]) ? $this->routes[$uri] : array();
    }

    public function dispatch($httpMethod, $uri)
   {
        if (!$this->httpMethodIsAllowed($httpMethod)) {
            return array(HttpStatusCodeService::METHOD_NOT_ALLOWED);
        }

        $routeMatched = $this->routeIsMatched($uri);

        if (empty($routeMatched)) {
            return array(HttpStatusCodeService::NOT_FOUND);
        }

        $routeInfo = $routeMatched[1];

        if ($this->checkClassInfo($routeInfo)) {
            return array(HttpStatusCodeService::SERVER_ERROR);
        }

        array_unshift($routeInfo, HttpStatusCodeService::MATCHED);

        return $routeInfo;
   }

    public function addRoute($httpMethod, $uri, $classInfo)
    {
        $this->routes[$uri] = array($httpMethod, $classInfo);
    }

}