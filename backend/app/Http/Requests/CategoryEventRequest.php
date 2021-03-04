<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryEventRequest extends FormRequest
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
            'name' => 'required|min:3|max:30|unique:category_events,name,'.$this->categoria_evento,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'name.min' => 'O campo nome deve ter no minimo 3 caracteres',
            'name.max' => 'O campo nome deve ter no maximo 30 caracteres',
            'name.unique' => 'Esse nome já existe',
        ];
    }
}
