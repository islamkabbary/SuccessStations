<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends AbstractFormRequest
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
            'city_id'=>'required|exists:cities,id',
            'district'=>'sometimes|nullable|string',
            'street'=>'sometimes|nullable|string',
            'building_number'=>'sometimes|nullable|string',
            'apartment_number'=>'sometimes|nullable|string',
            'floor'=>'sometimes|nullable|string',
            'location_details'=>'sometimes|nullable|string',
            'lat'=>'required',
            'lng'=>'required',
            'tag_id'=>'sometimes|nullable|exists:tags,id',
            'tag_name'=>'sometimes|nullable|string',
        ];
    }
}
