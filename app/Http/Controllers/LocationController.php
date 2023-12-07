<?php

namespace App\Http\Controllers;

use App\Contracts\ControllerFlowInterface;
use App\Models\Location;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;

class LocationController extends Controller implements ControllerFlowInterface
{
    private $location;
    public function __construct(Location $location)
    {
        $this->location = $location;
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
        return $this->successResponse('Locações listados com sucesso', $this->location->all());
    }

    public function store(StoreLocationRequest $request)
    {
        $this->location->create($request->all());
    }

    public function show(int $id)
    {
        $location = $this->location->find($id);
        if ($location === null) {
            return $this->errorResponse('Recurso não encontrado');
        }
        return $this->successResponse('Locação encontrada com sucesso', $this->location->all());
    }

    public function update(UpdateLocationRequest $request, int $id)
    {
        $location = $this->location->find($id);
        if ($location === null) {
            return $this->errorResponse('Locação não atulizada. Recurso não encontrado');
        }
        $this->location->update($request->all());
        return $this->successResponse('Locação atualizada com sucesso');
    }

    public function destroy(int $id)
    {
        $location = $this->location->find($id);
        if ($location === null) {
            return $this->errorResponse('Locação não removida. Recurso não encontrado');
        }
        $location->delete();
        return $this->successResponse('Locação removida com sucesso');
    }
}
