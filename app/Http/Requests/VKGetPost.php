<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VKGetPost extends APIRequest
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
	        'owner_id' => 'required|string|min:1',
	        'post_id' => 'required|string|min:1',
	        'fields' => 'string',
        ];
    }
}
