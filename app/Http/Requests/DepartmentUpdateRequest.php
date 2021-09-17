<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentUpdateRequest extends FormRequest
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
            'state_id' => ['required', 'integer', 'exists:states,id'],
            'name' => ['required', 'string', 'max:60'],
            'created_at' => ['required'],
            'updated_at' => ['required'],
        ];
    }
}