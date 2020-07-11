<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'card_id'       => 'required|exists:cards,id',
            'title'         => 'required|min:2|max:50',
            'description'   => 'required|min:2|max:250',
            'assigned_to'   => 'required|exists:users,id',
        ];
    }
}
