<?php

namespace App\Http\Controllers;

use App\Contracts\ControllerFlowInterface;
use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;

class CarController extends Controller implements ControllerFlowInterface
{
    private $car;

    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    public function successResponse(string $message, $data = null, int $status = 200)
    {
        $response = ['status' => 'success', 'message' => $message];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    public function errorResponse(string $message, int $status = 400)
    {
        $response = ['status' => 'error', 'message' => $message];
        return response()->json($response, $status);
    }

    public function index()
    {
        return  $this->successResponse('Carros listados com sucesso', $this->car->all());
    }

    public function store(StoreCarRequest $request)
    {
        $this->car->create($request->all());
        return $this->successResponse('Carro criada com sucesso');
    }

    public function show(int $id)
    {
        $car = $this->car->find($id);
        if ($car === null) {
            return $this->errorResponse('Recurso não encontrado');
        }
        return $this->successResponse('Carro encontrado com sucesso', $car);
    }

    public function update(UpdateCarRequest $request, int $id)
    {
        $car = $this->car->find($id);
        if ($car === null) {
            return $this->errorResponse('Carro não atualizado. Recurso não encontrado');
        }
        $car->update($request->all());
        return $this->successResponse('Carro atualizado com sucesso');
    }

    public function destroy(int $id)
    {
        $car = $this->car->find($id);
        if ($car === null) {
            return $this->errorResponse('Carro não removido. Recurso não encontrado');
        }
        $car->delete();
        return $this->successResponse('Carro removido com sucesso');
    }
}
