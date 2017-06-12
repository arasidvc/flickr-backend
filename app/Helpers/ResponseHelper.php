<?php
namespace App\Helpers;

class ResponseHelper
{
    /**
     * Create api success response object from supplied data
     *
     * @param string $message
     * @param array $data
     * @return object
     */
    public static function getApiSuccessResponseObject($message, array $data = [])
    {
        $response["message"] = $message;
        $response["data"] = (object)$data;

        return response()->json(
            (object)$response,
            config('constants.HTTP_CODES.SUCCESS'),
            [],
            JSON_NUMERIC_CHECK
        );
    }

    /**
     * Create api error response object from supplied error data
     *
     * @param string $message
     * @param array $data
     * @return object
     */
    public static function getApiErrorResponseObject($code, $message, array $errors)
    {
        $response["message"] = $message;
        $response["errors"] = $errors;

        return response()->json((object)$response, $code);
    }

    /**
     * Format validation error messages (Custom messages having delimiter '@@')
     * Used for formating as per API requirements
     * @param array $errors
     * @param boolean $isApiResponse default is false
     */
    public static function paraseValidationErrors(array $errors, $isApiResponse = false)
    {
        $formattedErrors = [];

        foreach ($errors as $field => $fieldErrors) {
            $fieldError = [];
            $error = explode("@@", $fieldErrors[0]);

            if ($isApiResponse && !empty($error[1])) {
                $fieldError['type'] = $field;
                $fieldError['message'] = $error[0];
                $fieldError['code'] = $error[1];
                $formattedErrors[] = $fieldError;
            } else {
                $formattedErrors[$field] = [$error[0]];
            }
        }

        return $formattedErrors;
    }

    /**
     * Internal server error array for API
     * @return array
     */
    public static function internalServerError()
    {
        $error = [
            'type' => "server",
            'message' => "Internal server error",
            'code' => "internal_server_error"
        ];

        return [$error];
    }
}
