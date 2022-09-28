<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'whatsapp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'terms' => 'sometimes|nullable|string',
            'policy' => 'sometimes|nullable|string',
            'advertising' => 'sometimes|nullable|string',
            'country_id' => 'required|unique:settings,country_id|exists:countries,id',
        ];
    }
    public function messages()
    {
        return [
            'country_id.unique' => "I Can't",
        ];
    }
}
