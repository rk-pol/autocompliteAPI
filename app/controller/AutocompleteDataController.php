<?php

namespace App\Controller;

use App\Service\HttpStatusCodeService;
use App\Service\RequestService;
use App\Service\ResponseService;

class AutocompleteDataController
{
    const MAX_SIZE = 6;

    public static function autocomplete()
    {
        if (!empty($_POST) && isset($_POST['keyword'])) {
            $responseData = self::fetchAndPrepareData($_POST['keyword']);
        } else {
            $responseData = [];
        }

        ResponseService::sendResponse(HttpStatusCodeService::MATCHED, $responseData);
    }

    private static function fetchAndPrepareData($keyword)
    {
        $url = 'https://www.bookcityride.co.il/new/task/autocomplete.php';
        $params = [
            'token' => '4d72a1a44295979bfea519926bb85df7',
            'command' => 'auto_complete_multi_location',
            'keyword' => htmlspecialchars($keyword)
        ];

        $responseData = RequestService::request($url, $params);
        return self::prepareData($responseData);
    }

    private static function prepareData($responseData)
    {
        if (isset($responseData)) {
            $data = json_decode($responseData, true, 4);

            $arrayAPT = [];
            $arraySeaPort = [];
            $arrayLocation = [];

            foreach ($data as $value) {
                switch ($value['type']) {
                    case 0:
                        $arrayAPT[] = $value;
                        break;
                    case 1:
                        $arrayLocation[] = $value;
                        break;
                    case 2:
                        $arraySeaPort[] = $value;
                        break;
                }
            }

            $arrayAPTResult = self::sliceArray($arrayAPT, 2);
            $arraySeaPortResult = self::sliceArray($arraySeaPort, 2);
            $currentCount = self::MAX_SIZE - (count($arrayAPTResult) + count($arraySeaPortResult));
            $arrayLocationResult = self::sliceArray($arrayLocation, $currentCount);

            return array_merge($arrayAPTResult, $arraySeaPortResult, $arrayLocationResult);
        }

        return $responseData;
    }

    private static function sliceArray($array, $size, $start = 0)
    {
        if (!empty($array) && count($array) > $size) {
            return array_slice($array, $start, $size);
        } else {
            return $array;
        }
    }
}