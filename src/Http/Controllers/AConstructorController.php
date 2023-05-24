<?php

namespace Nieeonliv\AConstructor\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Nieeonliv\AConstructor\Actions\FindModelsAction;
use Nieeonliv\AConstructor\Actions\RelationshipModelAction;
use Nieeonliv\AConstructor\Http\Requests\AConstructorRequest;

class AConstructorController extends Controller
{
    public function index(FindModelsAction $action): JsonResponse
    {
        return response()->json($action->handle());
    }

    public function fillable(AConstructorRequest $request): JsonResponse
    {
        $data = $request->validated();
        return response()->json(App::make("App\\Models\\${data['model']}")->getFillable());
    }

    public function store(AConstructorRequest $request)
    {
        $data = $request->validated();
        try {
            $model = App::make("App\\Models\\${data['model']}");
            return $model->create($data['data']);
        } catch (\Exception $e) {
            return response($e, 400);
        }
    }

    public function update($id, AConstructorRequest $request)
    {
        $data = $request->validated();
        $model = App::make("App\\Models\\${data['model']}");
        return $model->find($id)->update($data['data']);
    }

    public function destroy($id, AConstructorRequest $request)
    {
        $data = $request->validated();
        $model = App::make("App\\Models\\${data['model']}");
        return $model->find($id)->delete();
    }

    public function show(AConstructorRequest $request): Response
    {
        $data = $request->validated();
        $model = App::make("App\\Models\\${data['model']}");
        if (isset($data['data'][0])) {
            return response($model->with($request->validated()['data'])->get(), 200);
        } else {
            return response($model->all(), 200);
        }
    }

    public function relationship(AConstructorRequest $request, RelationshipModelAction $action): Response
    {
        $data = $request->validated();
        $model = App::make("App\\Models\\${data['model']}");
        return response($action->handle($model), 200);
    }
}
