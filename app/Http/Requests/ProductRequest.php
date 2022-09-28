<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'price' => 'required|numeric',
            'qty' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'image' => 'required|array',
            'image.*' => 'required|image',
        ];

        if(request('_method' )== 'PUT'){
            $rules['name'] = 'sometimes|string|max:255';
            $rules['price'] = 'sometimes|numeric';
            $rules['qty'] = 'sometimes|numeric';
            $rules['status'] = 'sometimes|nullable|string|max:255';
            $rules['image'] = 'sometimes|array';
            $rules['image'] = 'sometimes|nullable|image';
        }

        return $rules;
    }
}
