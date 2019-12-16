<?php

namespace App\Http\Requests;

use App\Services\Base\RegexService;
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
            'type_id'           => 'required|exists:replay_types,id',
            'map_id'            => 'required|exists:replay_maps,id',
            'first_race'        => 'required|exists:races,id',
            'first_country_id'  => 'required|string|exists:countries,id',
            'first_location'    => 'nullable|between:1,20|numeric',
            'second_race'       => 'required|string|exists:races,id',
            'second_country_id' => 'required|string|exists:countries,id',
            'second_location'   => 'nullable|between:1,20|numeric',
            'content'           => 'required|string|between:10,1000',
            'src_iframe'        => 'required_without:file|url|max:255',
            'file'              => 'required_without:src_iframe|file|max:5120',
            'user_replay'       => 'required|in:1,0',
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
            'content.required'     => 'Краткое описание обязаельно для заполнения',
            'content.string'       => 'Краткое описание должно быть  типом строки',
            'content.between'      => 'Краткое описание должно быть между 10 и 1000 символов',
        ];
    }

}
