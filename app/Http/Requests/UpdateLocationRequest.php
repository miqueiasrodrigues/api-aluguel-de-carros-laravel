<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
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

    public function rules()
    {
        $rules = [
            'client_id' => 'required|exists:clients,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'final_date' => 'required|date|after:start_date',
            'date_realized' => 'required|date',
            'daily_value' => 'required|numeric',
            'initial_km' => 'required|numeric',
        ];

        if ($this->isMethod('patch')) {
            $rules['client_id'] = 'sometimes|required|exists:clients,id';
            $rules['car_id'] = 'sometimes|required|exists:cars,id';
            $rules['start_date'] = 'sometimes|required|date';
            $rules['final_date'] = 'sometimes|required|date|after:start_date';
            $rules['date_realized'] = 'sometimes|required|date';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'client_id.required' => 'O campo :attribute é obrigatório.',
            'client_id.exists' => 'O cliente selecionado não foi encontrado.',
            'car_id.required' => 'O campo :attribute é obrigatório.',
            'car_id.exists' => 'O carro selecionado não foi encontrado.',
            'start_date.required' => 'O campo :attribute é obrigatório.',
            'start_date.date' => 'A data de início deve ser uma data válida.',
            'final_date.required' => 'O campo :attribute é obrigatório.',
            'final_date.date' => 'A data final deve ser uma data válida.',
            'final_date.after' => 'A data final deve ser posterior à data de início.',
            'date_realized.required' => 'O campo :attribute é obrigatório.',
            'date_realized.date' => 'A data realizada deve ser uma data válida.',
            'daily_value.required' => 'O campo :attribute é obrigatório.',
            'daily_value.numeric' => 'O valor diário deve ser um número.',
            'initial_km.required' => 'O campo :attribute é obrigatório.',
            'initial_km.numeric' => 'O valor inicial em quilômetros deve ser um número.',
        ];
    }
}
