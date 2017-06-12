<?php
namespace App\Helpers;

use Curl;

class FlickrApiHelper
{
    /**
     * To call flickr api and return response
     *
     * @param string $method
     * @param int $photoId
     * @param int $page
     * @param int $perPage
     * @param string $format
     * @return mixed
     */
    public static function call($method, $photoId = null, $page = null,
        $perPage = null, $format = 'php_serial'
    )
    {
        $url = config('constants.FLICKR_BASE_URL') .
            '?method=' . $method .
            '&format=' . $format .
            '&api_key=' . env('FLICKR_API_KEY');

        if (!empty($photoId)) {
            $url .= '&photo_id=' . $photoId;
        }

        if ($page != null && $perPage != null) {
            $url .= '&page=' . $page . '&per_page=' . $perPage;
        }

        $response = Curl::requestFlickrApi($url);

        if ($format == config('constants.RESPONSE_TYPES.SERIALIZE')) {
            return unserialize($response);
        }

        return $response;
    }

    /**
     * To get url from data provided.
     *
     * @param array $data
     * @return string
     */
    public static function getUrl(array $data)
    {
        return  'https://farm' . $data['farm'] . '.staticflickr.com/'
            . $data['server'] . '/' . $data['id'] . '_' . $data['secret'] . '.jpg';
    }
}
