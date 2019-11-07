<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplayUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user() && auth()->user()->role_id != 4;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|between:1,255',
            'type_id' => 'exists:replay_types,id',
            'map_id' => 'exists:replay_maps,id',
            'first_race' => 'exists:races,id',
            'first_country_id' => 'string|exists:countries,id',
            'first_location' => 'nullable|integer|min:1|max:20',
            'second_race' => 'string|exists:races,id',
            'second_country_id' => 'string|exists:countries,id',
            'second_location' => 'nullable|integer|min:1|max:20',
            'content' => 'string|between:1,2000',
            'video_iframe' => 'nullable|string|between:1,5000',
            'file' => 'nullable|file|max:5120',
        ];
    }
}
