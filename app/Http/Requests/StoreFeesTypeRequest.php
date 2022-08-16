<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeesTypeRequest extends FormRequest
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
            'Name_ar' => 'required|unique:fees_types,Name,'.$this->Feesid,
            'Name_en' => 'required|unique:fees_types,Name,'.$this->Feesid,
        ];


    }

    public function messages()
    {
        return [
            'Name_ar.required' => trans('validation.required'),
            'Name_ar.unique' => trans('validation.unique'),
            'Name_en.required' => trans('validation.required'),
            'Name_en.unique' => trans('validation.unique'),
            
        ];
    }
}
