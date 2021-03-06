<?php

namespace App\Http\Requests\Api\Area;

use Illuminate\Foundation\Http\FormRequest;

class CreateAreaRequest extends FormRequest
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
            'name_en' => "required|regex:/^[A-Za-z0-9_ ?]+$/|unique:areas,name_en",
            'name_ar' => "required|regex:/^[ء-ي ?0-9]+$/u|unique:areas,name_ar",
            'city_id' => "required|exists:cities,id"
        ];
    }
}
