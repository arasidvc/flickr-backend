<?php
namespace App\Helpers;

class CurlHelper
{
    /**
     * To call flickr api & return response
     *
     * @param string $url
     * @return mixed
     */
    public static function requestFlickrApi($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, config('constants.CURL_TIMEOUT'));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
