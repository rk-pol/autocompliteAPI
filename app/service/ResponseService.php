<?php


namespace App\Service;


class ResponseService
{
    private static function isAJAXRequest()
    {
        if(
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            return true;
        }

        return false;
    }

    public static function sendResponse($statusCode, $data = [])
    {
        header($_SERVER["SERVER_PROTOCOL"] . ' ' . $statusCode . ' ' . HttpStatusCodeService::getStatusCodeMessage($statusCode));

        if (self::isAJAXRequest()) {
            header('Content-Type: application/json');
            echo json_encode($data, 64);
            die();
        }

        header('ContentType: text/html; charset=utf-8');
        echo !empty($data) ? $data : '';
        die();
    }


}