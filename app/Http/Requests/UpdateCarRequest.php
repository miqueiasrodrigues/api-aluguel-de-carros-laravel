<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'car_model_id' => 'required|exists:car_models,id',
            'plate' => 'required|unique:cars,plate',
            'available' => 'required|boolean',
            'km' => 'required|numeric',
        ];

        if ($this->isMethod('patch')) {
            $rules['car_model_id'] = 'sometimes|required|exists:car_models,id';
            $rules['plate'] = 'sometimes|required|unique:cars,plate';
            $rules['available'] = 'sometimes|required|boolean';
            $rules['km'] = 'sometimes|required|numeric';
        }
    }

    public function messages()
    {
        return [
            'car_model_id.required' => 'O campo :attribute é obrigatório.',
            'car_model_id.exists' => 'O modelo de carro selecionado não existe.',
            'plate.required' => 'O campo :attribute é obrigatório.',
            'plate.unique' => 'Esta placa já está em uso.',
            'available.required' => 'O campo :attribute é obrigatório.',
            'available.boolean' => 'O campo Disponível deve ser verdadeiro ou falso.',
            'km.required' => 'O campo :attribute é obrigatório.',
            'km.numeric' => 'O campo Quilometragem deve ser um número.',
        ];
    }
}
