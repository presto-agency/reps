<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchGeneratorRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'         => 'required|exists:tourney_lists,id',
            'type'       => 'required|in:1,2',
            'round'      => 'required|numeric|min:1',
            'allPlayers' => 'nullable|numeric|min:0',
        ];
    }

}
