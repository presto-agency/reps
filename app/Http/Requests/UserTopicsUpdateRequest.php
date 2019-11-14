<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTopicsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  auth()->user() && auth()->user()->role_id != 4;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'forum_section_id' => 'exists:forum_sections,id',
            'title' => 'between:1,255|string',
            'preview_content' => 'between:1,1000|string',
            'content' => 'between:1,50000|string',
            'preview_img' => 'nullable|image|max:2048',
        ];
    }
}
