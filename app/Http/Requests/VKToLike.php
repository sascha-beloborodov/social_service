<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VKToLike extends APIRequest
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
            'type' => 'required|string|min:1',
            'owner_id' => 'required|integer|min:1',
            'item_id' => 'required|integer|min:1',
        ];
    }
}
