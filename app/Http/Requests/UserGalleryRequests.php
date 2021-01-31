<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGalleryRequests extends FormRequest
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
            'picture'    => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sign'       => 'nullable|string|between:1,255',
            'for_adults' => 'boolean',
        ];
    }

}
