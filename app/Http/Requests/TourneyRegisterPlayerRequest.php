<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourneyRegisterPlayerRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->isNotBan() && auth()->user()->isVerified();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|max:50',
            'tourneyId'   => 'exists:tourney_lists,id',
        ];
    }

}
