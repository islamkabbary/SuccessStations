<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'owner_id' => 'required|integer|exists:users,id',
            'mobile' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'number_company' => 'required|integer',
            'image' => 'required|image|max:2048',
            'service_id' => 'required|array',
            'service_id' => 'exists:services,id',
        ];

        if(request('_method' )== 'PUT'){
            $rules['image'] = 'sometimes|nullable|image';
        }

        return $rules;
    }
}
