<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VKCreatePost extends APIRequest
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
            'owner_id' => 'required|integer|min:1',
	        'message' => 'required|string|max:65000',
	        'from_group' => 'integer',
	        'attachments' => 'string',
        ];
    }
}
