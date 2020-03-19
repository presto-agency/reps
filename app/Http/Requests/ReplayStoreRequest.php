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
            'title'             => 'required|string|between:5,255',
            'subtype'           => 'required|exists:replay_types,id',
            'type'              => 'required|boolean',
            'map'               => 'required|exists:replay_maps,id',
            'first_race'        => 'required|exists:races,id',
            'first_country'     => 'required|string|exists:countries,id',
            'first_location'    => 'nullable|between:1,20|numeric',
            'second_race'       => 'required|string|exists:races,id',
            'second_country'    => 'required|string|exists:countries,id',
            'second_location'   => 'nullable|between:1,20|numeric',
            'short_description' => 'nullable|string|between:10,1000',
            'src_iframe'        => 'nullable|required_without:file|url|max:255',
            'file'              => 'nullable|required_without:src_iframe|file|max:5120',

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
            'short_description.required' => 'Краткое описание обязаельно для заполнения',
            'short_description.string'   => 'Краткое описание должно быть типом строки',
            'short_description.between'  => 'Краткое описание должно быть между 10 и 1000 символов',
            'video_iframe_url.url'      => 'Указанный URL для Video Iframe имеет ошибочный формат.',
            'video_iframe_url.max'      => 'Указанный URL для Video Iframe не должен быть длионй до 500 символов',
        ];
    }

}
