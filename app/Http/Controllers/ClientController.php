<?php

namespace App\Http\Controllers;

use App\Contracts\ControllerFlowInterface;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;


class ClientController extends Controller implements ControllerFlowInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
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
        return $this->successResponse('Clientes listados com sucesso', $this->client->all());
    }

    public function store(StoreClientRequest $request)
    {
        $this->client->create($request->all());
        return $this->successResponse('Cliente criado com sucesso');
    }

    public function show(int $id)
    {
        $client = $this->client->find($id);

        if ($client === null) {
            return $this->errorResponse('Recurso não encontrado');
        }
        return $this->successResponse('Cliente encontrado com sucesso', $client);
    }

    public function update(UpdateClientRequest $request, int $id)
    {
        $client = $this->client->find($id);

        if ($client === null) {
            return $this->errorResponse('Cliente não foi atualizado. Recurso não encontrado');
        }

        $client->update($request->all());
        return $this->successResponse('Cliente atualizado com sucesso');
    }

    public function destroy(int $id)
    {
        $client = $this->client->find($id);

        if ($client === null) {
            return $this->errorResponse('Cliente não foi removido. Recurso não encontrado');
        }

        $client->delete();
        return $this->successResponse('Cliente removido com sucesso');
    }
}
