<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Contracts\ControllerFlowInterface;
use App\Http\Requests\StoreCarModelRequest;
use App\Http\Requests\UpdateCarModelRequest;

class CarModelController extends Controller implements ControllerFlowInterface
{
    private CarModel $model;

    public function __construct(CarModel $model)
    {
        $this->model = $model;
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
        return response()->json(['status' => 'error', 'message' => $message], $status);
    }

    public function index(Request $request)
    {
        $attributesBrandArray =
            $request->has('attributes_brand') ?
            explode(',', $request->get('attributes_brand')) :
            array();
        $attributesArray =
            $request->has('attributes') ?
            explode(',', $request->get('attributes')) :
            array();
        $attributesBrand = in_array('id', $attributesBrandArray) ?
            ':' . $request->get('attributes_brand') :
            '';

        $query = !empty($attributesArray) ? $this->model : $this->model->with('brand' . $attributesBrand);

        if (!empty($attributesArray)) {
            $query = $query->select($attributesArray);

            if (in_array('brand_id', $attributesArray)) {
                $query->with('brand' . $attributesBrand);
            }
        }

        $models = $query->get();

        return $this->successResponse('Modelos de carro listados com sucesso', $models);
    }

    public function store(StoreCarModelRequest $request)
    {
        $image = $request->file('image');
        $image_urn = $image->store('images/models', 'public');

        $this->model->create([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'image' => $image_urn,
            'num_door' => $request->num_door,
            'num_places' => $request->num_places,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);
        return $this->successResponse('Modelo de carro criado com sucesso');
    }

    public function show(int $id, Request $request)
    {
        $attributesBrandArray =
            $request->has('attributes_brand') ?
            explode(',', $request->get('attributes_brand')) :
            array();
        $attributesArray =
            $request->has('attributes') ?
            explode(',', $request->get('attributes')) :
            array();
        $attributesBrand = in_array('id', $attributesBrandArray) ?
            ':' . $request->get('attributes_brand') :
            '';

        $query = !empty($attributesArray) ? $this->model : $this->model->with('brand' . $attributesBrand);

        if (!empty($attributesArray)) {
            $query = $query->select($attributesArray);

            if (in_array('brand_id', $attributesArray)) {
                $query->with('brand' . $attributesBrand);
            }
        }

        $model = $query->find($id);
        return $this->successResponse('Modelo de carro encontrado com sucesso', $model);
    }

    public function update(UpdateCarModelRequest $request, int $id)
    {
        $model = $this->model->find($id);
        if ($model === null) {
            return $this->errorResponse('Modelo de carro não atualizado. Recurso não encontrado');
        }

        if ($request->file('image') != null) {
            Storage::disk('public')->delete($model->image);
        }

        $image = $request->file('image');
        $image_urn = $image->store('image/models', 'public');

        $model->fill($request->all());
        $model->image = $image_urn;
        $model->save();

        return $this->successResponse('Modelo de carro atualizado com sucesso');
    }

    public function destroy(int $id)
    {
        $model = $this->model->find($id);

        if ($model === null) {
            return $this->errorResponse('Modelo de carro não foi removido. Recurso não encontrado');
        }

        Storage::disk('public')->delete($model->image);
        $model->delete();
        return $this->successResponse('Modelo de carro removido com sucesso');
    }
}
