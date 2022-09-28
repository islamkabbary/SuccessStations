<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoCodeRequest extends AbstractFormRequest
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
            'code'=>'required|unique:promo_codes,code',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
            'type'=>'required|in:fixed,percentage',
            'discount'=>'required|numeric|min:0',
            'max_discount'=>'required_if:type,==,percentage|nullable|numeric|min:0',
            'limit_for_user'=>'sometimes|nullable|integer|min:0',
            'limit_use'=>'sometimes|nullable|integer|min:0',
        ];

        if(request('_method' )== 'PUT'){
            $rules['code'] = 'required|unique:promo_codes,code,'.request('id');
        }

        return $rules;
    }
}
