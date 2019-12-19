<?php

namespace App\Http\Requests;

use App\Services\Base\RegexService;
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
            'title'             => 'string|between:1,255',
            'type_id'           => 'exists:replay_types,id',
            'map_id'            => 'exists:replay_maps,id',
            'first_race'        => 'exists:races,id',
            'first_country_id'  => 'string|exists:countries,id',
            'first_location'    => 'nullable|between:1,20|numeric',
            'second_race'       => 'string|exists:races,id',
            'second_country_id' => 'string|exists:countries,id',
            'second_location'   => 'nullable|between:1,20|numeric',
            'content'           => 'string|nullable|between:10,1000',
            'src_iframe'        => 'url|max:255',
            'file'              => 'file|max:5120',
            'user_replay'       => 'in:1,0',
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
            'video_iframe_url.url' => 'Указанный URL для Video Iframe имеет ошибочный формат.',
            'video_iframe_url.max' => 'Указанный URL для Video Iframe не должен быть длионй до 500 символов',
        ];
    }

}
