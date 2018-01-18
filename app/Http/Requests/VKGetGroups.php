<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VKGetGroups extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	        'user_id' => 'integer|min:1',
	        'extended' => 'integer',
	        'fields' => 'string|min:1',
        ];
    }
}
