<?php

namespace App\Http\Requests;

use App\Constants\Constants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    public function failedValidation(Validator $validator): void
    {
        $collection = collect($validator->errors())->flatten(1);
        $messages   = collect(['messages' => $collection]);
        throw new HttpResponseException(
            response()->json($messages, Constants::SERVER_STATES['unprocessable'])
        );
    }
}
