<?php


namespace App\Service;


class RequestService
{
    public static function request($url, $postData)
    {
        $responseData = [];
        if (!empty($postData)) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
            $responseData = curl_exec($curl);
            curl_close($curl);
        }

        return $responseData;
    }
}