<?php

use Illuminate\Support\Facades\Route;
use Nieeonliv\AConstructor\Enums\AConstructorScopeEnum;
use Nieeonliv\AConstructor\Http\Controllers\AConstructorController;

//
Route::prefix('aconstructor')->group(function () {
    Route::controller(AConstructorController::class)->group(function () {
        Route::get('', 'index');

        Route::prefix('{mode}')->group(function () {
            Route::get('fillable', 'fillable');
            Route::get('relationship', 'relationship');
            Route::get('','show');
            Route::post('', 'store');
            Route::patch('{id}', 'update');
            Route::delete('{id}', 'destroy');
        });
    });
});
