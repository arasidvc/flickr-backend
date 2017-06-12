<?php
namespace App\Services;

use FlickrHelper;

class FlickrServices
{
    /**
     * To get list of recent photos.
     *
     * @return array
     */
    public function getRecentPhotos($request)
    {
        $page = !empty($request->get('page')) ? $request->get('page') :
            config('constants.DEFAULT_PAGE');
        $perPage = !empty($request->get('per_page')) ? $request->get('per_page') :
            config('constants.PER_PAGE');

        $response = FlickrHelper::call(
            config('constants.API_METHODS.RECENT_PHOTOS'), null, $page, $perPage
        );

        if ($response['stat'] == 'ok') {
            return $this->getDataForGallery($response);
        }

        return [];
    }

    /**
     * To prepare data for photo-gallery and return
     *
     * @param type $data
     * @return array $photoData
     */
    private function getDataForGallery($data)
    {
        $photoData = array_only($data['photos'], ['page', 'pages', 'perpage', 'total']);

        foreach ($data['photos']['photo'] as $photo) {
            $tempData = [];
            $tempData['id'] = $photo['id'];
            $tempData['url'] = FlickrHelper::getUrl($photo);
            $photoData['images'][] = $tempData;
        }

        return $photoData;
    }

    /**
     * To get photo detials with all avaiable sizes.
     *
     * @param int $id
     * @return array
     */
    public function getPhotoDetails($id)
    {
        $response = FlickrHelper::call(config('constants.API_METHODS.PHOTO_SIZES'), $id);

        if ($response['stat'] == 'ok') {
            $data = [];
            if (isset($response['sizes']['size']) &&
                !empty($response['sizes']['size'])) {
                $url = $response['sizes']['size'][0]['source'];
                $splittedUrl = explode("_", $url);
                array_pop($splittedUrl);
                $data['url'] = implode("_", $splittedUrl) . '.jpg';
                $data['sizes'] = $response['sizes']['size'];
            }

            return $data;
        }

        return [];
    }
}
