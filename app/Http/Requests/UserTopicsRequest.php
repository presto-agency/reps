<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTopicsRequest extends FormRequest
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
            'forum_section_id' => 'required|string|exists:forum_topics,id',
            'title' => 'required|string|between:1,255',
            'preview_content' => 'nullable|string|max:1000',
            'content' => 'required|string|min:3|max:50000',
            'preview_img' => 'nullable|image|max:2048',
        ];
    }
}
