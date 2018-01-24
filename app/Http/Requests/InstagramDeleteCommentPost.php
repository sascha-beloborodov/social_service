<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstagramDeleteCommentPost extends APIRequest
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
            'media_url' => 'string|required|min:1',
            'comment_ids' => 'string|required|min:1',
        ];
    }
}
