<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTopicsStoreRequest extends FormRequest
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
            'forum_section'   => 'required|exists:forum_sections,id',
            'title'           => 'required|string|between:5,255',
            'preview_img'     => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'preview_content' => 'nullable|between:10,10000',
            'content'         => 'required|string|between:10,50000',
        ];
    }

}
