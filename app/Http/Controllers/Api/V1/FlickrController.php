<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecentPhotoRequest;
use App\Services\FlickrServices;
use ResponseHelper;

class FlickrController extends Controller
{
    /**
     * Service objects
     *
     * @var object
     */
    private $flickrService;

    /**
     * To initialize objects/varibale of class.
     *
     * @param FlickrServices $flickrService
     */
    public function __construct(FlickrServices $flickrService)
    {
        $this->flickrService = $flickrService;
    }

    /**
     * To get recent photos which are publically available at flickr.
     *
     * @return json
     */
    public function getRecentPhotos(RecentPhotoRequest $request)
    {
        $data = $this->flickrService->getRecentPhotos($request);
        
        return ResponseHelper::getApiSuccessResponseObject(
            "Recent photo list fetched successfully",
            $data
        );
    }

    /**
     * To get details of requested photo.
     *
     * @param int $id
     * @return json
     */
    public function viewPhoto($id)
    {
        $data = $this->flickrService->getPhotoDetails($id);

        return ResponseHelper::getApiSuccessResponseObject(
            "Photo details fetched successfully",
            $data
        );
    }
}
