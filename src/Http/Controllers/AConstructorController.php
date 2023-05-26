<?php

namespace Nieeonliv\AConstructor\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Nieeonliv\AConstructor\Actions\FindModelsAction;
use Nieeonliv\AConstructor\Actions\RelationshipModelAction;
use Nieeonliv\AConstructor\Http\Requests\AConstructorRequest;
use Nieeonliv\AConstructor\Http\Requests\AconstructorShowRequest;


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

    public function show(AconstructorShowRequest $request): Response
    {
        $data = $request->validated();
        $model = App::make("App\\Models\\${data['model']}");
        if (isset($data['relations'][0])) {
            $model = $model->with($request->validated()['relations']);
        }
        if (isset($data['sortKey'])) {
            if ($data['orderBy']) {
                $model = $model->orderBy($data['sortKey'], 'asc');
            } else {
                $model = $model->orderBy($data['sortKey'], 'desc');
            }
        }
        return response($model->paginate(15), 200);
    }

    public function relationship(AConstructorRequest $request, RelationshipModelAction $action): Response
    {
        $data = $request->validated();
        $model = App::make("App\\Models\\${data['model']}");
        return response($action->handle($model), 200);
    }
}
