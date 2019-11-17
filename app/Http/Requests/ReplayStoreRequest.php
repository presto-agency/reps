<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplayStoreRequest extends FormRequest
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
            'title' => 'required|string|between:1,255',
            'type_id' => 'required|exists:replay_types,id',
            'map_id' => 'required|exists:replay_maps,id',
            'first_race' => 'required|exists:races,id',
            'first_country_id' => 'required|string|exists:countries,id',
            'first_location' => 'nullable|integer|min:1|max:20',
            'second_race' => 'required|string|exists:races,id',
            'second_country_id' => 'required|string|exists:countries,id',
            'second_location' => 'nullable|integer|min:1|max:20',
            'content' => 'required|string|between:1,10000',
            'video_iframe' => 'nullable|string|between:1,5000',
            'file' => 'required|file|max:5120',
        ];
    }
}
