<?php

namespace Nieeonliv\AConstructor\Actions;


use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Nieeonliv\AConstructor\Models\EmptyObj;

class RelationshipModelAction
{
    public function handle($modelInstance): array
    {
        $methods = array_diff(get_class_methods($modelInstance), get_class_methods(new EmptyObj()));
        return Arr::where($methods, function ($method) use ($modelInstance) {
            try {
                return ($modelInstance->{$method}() instanceof Relation);
            } catch (\Throwable) { }
        });
    }
}
