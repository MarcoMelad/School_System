<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassrooms extends FormRequest
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
            'List_Classes.*.Name' => 'required',
            'List_Classes.*.Name_class_en' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'Name.required' => trans('My_Classes_trans.Name_class'),
            'Name_class_en.required' => trans('My_Classes_trans.Name_class_en'),
        ];
    }
}
