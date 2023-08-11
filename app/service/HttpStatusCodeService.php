<?php


namespace App\Service;


class HttpStatusCodeService
{
    const SERVER_ERROR = 500;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_FOUND = 404;
    const MATCHED = 200;

    public static function getStatusCodeMessage($statusCode)
    {
        switch ($statusCode) {
            case 200: $text = 'OK'; break;
            case 404: $text = 'Not Found'; break;
            case 405: $text = 'Method Not Allowed'; break;
            case 500: $text = 'Internal Server Error'; break;
            default:
                exit('Unknown http status code "' . htmlentities($statusCode) . '"');
                break;
        }

        return $text;
    }

}