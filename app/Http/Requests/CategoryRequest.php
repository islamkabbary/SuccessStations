<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends AbstractFormRequest
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
        $rules = [
            'name_ar'=>'required|string',
            'name_en'=>'required|string',
            'is_show'=>'required|in:0,1',
            'color'=>'required|string',
            'city_id'=>'required|exists:cities,id',
            'company_id' => 'required|array',
            'company_id'=>'exists:companies,id',
        ];
        
        if(request('_method' )== 'PUT'){
            $rules['company_id'] = 'sometimes|array';
            $rules['company_id'] = 'exists:companies,id';
        }

        return $rules;
    }
}
