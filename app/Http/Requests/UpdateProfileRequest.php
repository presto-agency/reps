<?php

namespace App\Http\Requests;

use App\Models\Replay;
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
//        $races = implode(",", Replay::$races);

        return [
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->id,
            'name' => 'required|regex:' . RegexService::regex('name') . '|max:255',
            'country' => 'required|exists:countries,id',
//            'userbar'       => 'nullable|in:0,'.implode(',', UserbarService::getItemsIds()),
//            'race'          => 'required|in:'.$races,
            'race' => 'required',
            'homepage' => 'nullable|url|regex:' . RegexService::regex('url') . '|max:255',
            'vk_link' => 'nullable|url|regex:' . RegexService::regex('url') . '|max:255',
            'fb_link' => 'nullable|url|regex:' . RegexService::regex('url') . '|max:255',
            'isq' => 'nullable|string|max:255',
            'skype' => 'nullable|string|regex:' . RegexService::regex('skype') . '|max:255',
            'signature' => 'nullable|string|max:255',
            'mouse' => 'nullable|string|max:255',
            'keyboard' => 'nullable|string|max:255',
            'headphone' => 'nullable|string|max:255',
            'mousepad' => 'nullable|string|max:255',
            'birthday' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
            'user_role_id' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'race.required' => 'Раса обязательна для заполнения.',
//            'race.in'        => 'Не верно указана расса',
            'race' => 'Не указана расса',
            'email.required' => 'Email обязательный для заполнения.',
            'email.email' => 'Введен не верный формат Email.',
            'email.unique' => 'Пользователь с таким Email уже зарегестрирован.',
            'email.max' => 'Максимальная длина Email 255 символов.',
            'name.required' => 'Не указно имя.',
            'name.max' => 'Максимальная длина имени 255 символов.',
            'name.regex' => 'Неверный формат имени (Не допускаются специальные символы, кроме `.,)_-`)',
            'country.exists' => 'Не верно указана страна.',
            'country.required' => 'Страна обязательна для заполнения.',
            'homepage.url' => 'Домашняя страница должна быть ссылкой.',
            'homepage.regex' => 'Это недействительный URL',
            'vk_link.url' => 'Страница Вконтакте должна быть ссылкой.',
            'vk_link.regex' => 'Это недействительный URL',
            'fb_link.url' => 'Страница Facebook должна быть ссылкой.',
            'fb_link.regex' => 'Это недействительный URL',
            'homepage.max' => 'Максимальная длина ссылки домашней страниы 255 символов.',
            'vk_link.max' => 'Максимальная длина ссылки на сраницу вконтакте 255 символов.',
            'fb_link.max' => 'Максимальная длина ссылки на страницу Facebook 255 символов.',
            'isq.max' => 'Максимальная длина номера ISQ 255 символов.',
            'skype.max' => 'Максимальная длина Skype 255 символов.',
            'skype.regex' => 'Ваше имя в скайпе содержит символы, которые не разрешены',
            'signature.max' => 'Максимальная длина подписи 255 символов.',
            'mouse.max' => 'Максимальная длина названия мыши 255 символов.',
            'keyboard.max' => 'Максимальная длина названия клавиатуры 255 символов.',
            'headphone.max' => 'Максимальная длина названия наушников 255 символов.',
            'mousepad.max' => 'Максимальная длина названия коврика для мыши 255 символов.',
            'avatar.max' => 'Максимальный размер картинки аватара 2мб.',
        ];
    }
}
