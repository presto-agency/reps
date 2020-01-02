<?php

namespace App\Http\Requests;

use App\Services\Base\RegexService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name'         => [
                'regex:'.RegexService::regex('name'),
                'required',
                'string',
                'between:3,30',
                'unique:users,name,'.$this->id,
            ],
            'email'        => [
                'required',
                'email',
                'string',
                'max:30',
                'unique:users,email,'.$this->id,
            ],
            'country'      => 'exists:countries,id',
            'race'         => 'exists:races,id',
            'homepage'     => 'nullable|url|regex:'.RegexService::regex('url').'|max:255',
            'vk_link'      => 'nullable|url|regex:'.RegexService::regex('url').'|max:255',
            'fb_link'      => 'nullable|url|regex:'.RegexService::regex('url').'|max:255',
            'skype'        => 'nullable|string|regex:'.RegexService::regex('skype').'|max:255',
            'isq'          => 'nullable|string|max:255',
            'signature'    => 'nullable|string|max:255',
            'birthday'     => 'nullable|date',
            'avatar'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'view_avatars' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.regex'     => 'Неверный формат имени (Не допускаются специальные символы, кроме `.,)_-`)',
            'homepage.regex' => 'Это недействительный URL',
            'vk_link.regex'  => 'Это недействительный URL',
            'fb_link.regex'  => 'Это недействительный URL',
            'skype.regex'    => 'Ваше имя в скайпе содержит символы, которые не разрешены',
        ];
    }

}
