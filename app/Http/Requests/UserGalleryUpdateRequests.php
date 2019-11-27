<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGalleryUpdateRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->id() == $this->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sign'       => 'nullable|string|between:1,255',
            'for_adults' => 'nullable|in:1',
        ];
    }
}
