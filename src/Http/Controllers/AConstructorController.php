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

    public function fillable($model): JsonResponse
    {
        return response()->json(App::make("App\\Models\\$model")->getFillable());
    }

    public function store($mode, AConstructorRequest $request)
    {
        $data = $request->validated();
        try {
            $model = App::make("App\\Models\\$mode");
            return $model->create($data['data']);
        } catch (\Exception $e) {
            return response($e, 400);
        }
    }

    public function update($mode, $id, AConstructorRequest $request)
    {
        $data = $request->validated();
        $model = App::make("App\\Models\\$mode");
        return $model->find($id)->update($data['data']);
    }

    public function destroy($mode, $id)
    {
        $model = App::make("App\\Models\\$mode");
        return $model->find($id)->delete();
    }

    public function show($mode, AConstructorRequest $request): Response
    {
        $model = App::make("App\\Models\\$mode");
        if (isset($request->validated()['data'][0])){
            return response($model->with($request->validated()['data'])->get(), 200);
        } else {
            return response($model->all(), 200);
        }
    }

    public function relationship($mode, RelationshipModelAction $action): Response
    {
        $model = App::make("App\\Models\\$mode");
        return response($action->handle($model), 200);
    }
}
