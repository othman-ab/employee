<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:60'],
            'adress' => ['required', 'string', 'max:120'],
            'zip_code' => ['required', 'string', 'max:10'],
            'userable_id' => ['required', 'string'],
            'userable_type' => ['required', 'string', 'max:120'],
            'date_hired' => ['required'],
            'created_at' => ['required'],
            'updated_at' => ['required'],
        ];
    }
}
