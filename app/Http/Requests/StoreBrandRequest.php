<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'name' => 'required|unique:brands',
            'image' => 'required|file|mimes:png,jpeg,jpg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo :attribute é obrigatório.',
            'name.unique' => 'Este nome de marca já está em uso.',
           
            'image.required' => 'O campo :attribute é obrigatório.',
            'image.file' => 'O arquivo deve ser um arquivo válido.',
            'image.mimes' => 'O arquivo deve ser dos tipos: PNG, JPEG, JPG.',
            'image.max' => 'O tamanho máximo do arquivo é 2 MB.',
        ];
    }
}
