<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
            'name' => 'required|unique:brands,name,' . $this->route('brand'),
            'image' => 'required|file|mimes:png,jpeg,jpg|max:2048',
        ];

        if ($this->isMethod('patch')) {
            $rules['name'] = 'sometimes|required|unique:brands,name,' . $this->route('brand');
            $rules['image'] = 'sometimes|required|file|mimes:png,jpeg,jpg|max:2048';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo :attribute é obrigatório.',
            'image.mimes' => 'O arquivo deve ser dos tipos: PNG, JPEG, JPG.',
            'name.unique' => 'Este nome de marca já está em uso.',
            'image.max' => 'O tamanho máximo do arquivo é 2 MB.',
        ];
    }
}
