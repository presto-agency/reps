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
        return auth()->user() && auth()->user()->isNotUser();
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
            'title'            => 'string|between:5,255',
            'preview_img'      => 'nullable|image|max:2048',
            'preview_content'  => 'nullable|string|between:10,10000',
            'content'          => 'string|between:10,50000',
        ];
    }

}
