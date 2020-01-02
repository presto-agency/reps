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
            'title'             => 'string|between:1,255',
            'subtype'           => 'exists:replay_types,id',
            'type'              => 'boolean',
            'map'               => 'exists:replay_maps,id',
            'first_race'        => 'exists:races,id',
            'first_country'     => 'string|exists:countries,id',
            'first_location'    => 'nullable|between:1,20|numeric',
            'second_race'       => 'string|exists:races,id',
            'second_country'    => 'string|exists:countries,id',
            'second_location'   => 'nullable|between:1,20|numeric',
            'short_description' => 'nullable|string|between:10,1000',
            'src_iframe'        => 'url|max:255',
            'file'              => 'file|max:5120',

        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'short_description.string'  => 'Краткое описание должно быть типом строки',
            'short_description.between' => 'Краткое описание должно быть между 10 и 1000 символов',
            'video_iframe_url.url'      => 'Указанный URL для Video Iframe имеет ошибочный формат.',
            'video_iframe_url.max'      => 'Указанный URL для Video Iframe не должен быть длионй до 500 символов',
        ];
    }

}
