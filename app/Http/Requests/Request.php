<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\ResponseHelper;

abstract class Request extends FormRequest
{
    /**
     * Overwritten to get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        //Send json error response to ajax, json and api requests
        if ($this->ajax() || $this->wantsJson() || $this->is('api/*')) {
            $apiErrors = ResponseHelper::paraseValidationErrors($errors, true);

            return ResponseHelper::getApiErrorResponseObject(
                config('constants.HTTP_CODES.VALIDATION_ERROR'),
                "validation error",
                $apiErrors
            );
        }

        //Remove api error code seperators from validation messages
        $formErrors = ResponseHelper::paraseValidationErrors($errors, false);

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($formErrors, $this->errorBag);
    }
}
