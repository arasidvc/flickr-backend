<?php

return [
    'API_METHODS' => [
        'RECENT_PHOTOS' => 'flickr.photos.getRecent',
        'PHOTO_SIZES' => 'flickr.photos.getSizes'
    ],
    'FLICKR_BASE_URL' => 'https://api.flickr.com/services/rest/',
    'RESPONSE_TYPES' => [
        'XML' => 'xml',
        'JSON' => 'json',
        'SERIALIZE' => 'php_serial'
    ],
    'HTTP_CODES' => [
        'SUCCESS' => 200,
        'VALIDATION_ERROR' => 412,
        'UNAUTHORIZED' => 401,
        'BAD_REQUEST' => 400,
        'INTERNAL_SERVER_ERROR' => 500
    ],
    'CURL_TIMEOUT' => 5,
    'DEFAULT_PAGE' => 1,
    'PER_PAGE' => 20,
];
