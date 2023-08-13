<?php
require_once __DIR__ . '/autoload.php';

use App\Service\RouteService;
use App\Service\ResponseService;
use App\Service\HttpStatusCodeService;

$route = new RouteService();

$route->addRoute('GET', '/', ['App\Controller\PageController', 'home']);
$route->addRoute('POST', '/autocomplete', ['App\Controller\AutocompleteDataController', 'autocomplete']);

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$routeInfo = $route->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case HttpStatusCodeService::NOT_FOUND:
        ResponseService::sendResponse(HttpStatusCodeService::NOT_FOUND);
        break;
    case HttpStatusCodeService::METHOD_NOT_ALLOWED:
        ResponseService::sendResponse(HttpStatusCodeService::METHOD_NOT_ALLOWED);
        break;
    case HttpStatusCodeService::MATCHED:
        $className = $routeInfo[1];
        $methodName = $routeInfo[2];

        $classObj = new $className();
        $data = $classObj->$methodName();

        ResponseService::sendResponse(HttpStatusCodeService::MATCHED, $data);
        break;
    default:
        ResponseService::sendResponse(HttpStatusCodeService::SERVER_ERROR);
        break;
}
