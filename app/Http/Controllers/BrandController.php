<?php

namespace App\Http\Controllers;

use App\Contracts\ControllerFlowInterface;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BrandController extends Controller implements ControllerFlowInterface
{
    private $brand;
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function successResponse(string $message, $data = null, int $status = 200)
    {
        $response = ['status' => 'success', 'message' => $message];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    public function errorResponse(string $message, $data = null, int $status = 400)
    {
        $response = ['status' => 'error', 'message' => $message];
        return response()->json($response, $status);
    }

    public function index(Request $request)
    {
        $brands = $this->brand->with('carModels')->get();
        if ($request->has('attributes')) {
            $attributes = $request->get('attributes');
            $attributesArray = explode(',', $attributes);
            $query = $this->brand->select($attributesArray);

            if (in_array('id', $attributesArray)) {
                $brands = $query->with('carModels')->get();
            } else {
                $brands = $query->get();
            }
        }
        return $this->successResponse('Marcas listadas com sucesso', $brands);
    }


    public function store(StoreBrandRequest $request)
    {
        $image = $request->file('image');
        $image_urn = $image->store('images/brands', 'public');

        $this->brand->create([
            'name' => $request->name,
            'image' => $image_urn,
        ]);
        return $this->successResponse('Marca criada com sucesso');
    }


    public function show(int $id, Request $request)
    {
        $brand = $this->brand->with('carModels')->find($id);

        if ($brand === null) {
            return $this->errorResponse('Recurso não encontrado');
        }

        if ($request->has('attributes')) {
            $attributes = $request->get('attributes');
            $attributesArray = explode(',', $attributes);
            $query = $this->brand->select($attributesArray);

            if (in_array('id', $attributesArray)) {
                $brand = $query->with('carModels')->find($id);
            } else {
                $brand = $query->find($id);
            }
        }

        return  $this->successResponse('Marca encontrada com sucesso', $brand);
    }


    public function update(UpdateBrandRequest $request, int $id)
    {
        $brand = $this->brand->find($id);

        if ($brand === null) {
            return $this->errorResponse('Marca não foi atualizado. Recurso não encontrado');
        }

        if ($request->file('image') != null) {
            Storage::disk('public')->delete($brand->image);
        }

        $image = $request->file('image');
        $image_urn = $image->store('images/brands', 'public');

        $brand->fill($request->all());
        $brand->image = $image_urn;
        $brand->save();

        return $this->successResponse('Marca atualizado com sucesso');
    }


    public function destroy(int $id)
    {
        $brand = $this->brand->find($id);

        if ($brand === null) {
            return $this->errorResponse('Marca não foi removido. Recurso não encontrado');
        }

        Storage::disk('public')->delete($brand->image);
        $brand->delete();
        return $this->successResponse('Marca removido com sucesso');
    }
}
