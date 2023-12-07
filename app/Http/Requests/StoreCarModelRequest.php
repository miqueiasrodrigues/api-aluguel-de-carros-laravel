<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarModelRequest extends FormRequest
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
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|unique:car_models',
            'image' => 'required|file|mimes:png,jpeg,jpg|max:2048',
            'num_door' => 'required|integer|digits_between:1,5',
            'num_places' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'brand_id.exists' => 'A marca selecionada não existe.',
            'brand_id.required' => 'O campo :attribute é obrigatório.',


            'name.required' => 'O campo :attribute é obrigatório.',
            'name.unique' => 'Este modelo de carro já está em uso.',

            'image.required' => 'O campo :attribute é obrigatório.',
            'image.file' => 'O arquivo deve ser um arquivo válido.',
            'image.mimes' => 'O arquivo deve ser dos tipos: PNG, JPEG, JPG.',
            'image.max' => 'O tamanho máximo do arquivo é 2 MB.',
            
            'num_door.required' => 'O campo :attribute é obrigatório.',
            'num_door.integer' => 'O campo :attribute deve ser um número inteiro.',
            'num_door.digits_between' => 'O campo :attribute deve ter entre 1 e 5 dígitos.',
            
            'num_places.required' => 'O campo :attribute é obrigatório.',
            'num_places.integer' => 'O campo :attribute deve ser um número inteiro.',
            'num_places.digits_between' => 'O campo :attribute deve ter entre 1 e 20 dígitos.',
            
            'air_bag.required' => 'O campo :attribute é obrigatório.',
            'air_bag.boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
            
            'abs.required' => 'O campo :attribute é obrigatório.',
            'abs.boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
        ];
    }
}
