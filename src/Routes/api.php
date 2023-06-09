<?php

use Illuminate\Support\Facades\Route;
use Nieeonliv\AConstructor\Enums\AConstructorScopeEnum;
use Nieeonliv\AConstructor\Http\Controllers\AConstructorController;

Route::middleware(['auth:admin', 'scopes:' . AConstructorScopeEnum::A_CONSTRUCTOR_ADMIN->value])->prefix('aconstructor/api')->group(function () {
    Route::controller(AConstructorController::class)->group(function () {
        Route::get('list', 'index');
        Route::get('fillable', 'fillable');
        Route::get('relationship', 'relationship');
        Route::get('', 'show');
        Route::post('', 'store');
        Route::patch('{id}', 'update');
        Route::delete('{id}', 'destroy');
    });
});
