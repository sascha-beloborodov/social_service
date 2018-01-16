<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstagramSendDirectImage extends APIRequest
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
		    'user_id' => 'required|integer|min:1',
		    'image' => 'required|max:10000|mimes:png,jpg,jpeg,gif',
	    ];
    }
}
