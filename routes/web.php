<?php

use App\Http\Controllers\ComponentTestController;
use App\Http\Controllers\LifeCycleTestController;
use App\Http\Controllers\User\CartsController;
use App\Http\Controllers\User\ItemsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:users')->group(function () {
    Route::get('/', [ItemsController::class, 'index'])
        ->name('items.index');
    Route::resource('items', ItemsController::class)
        ->only(['show']);
    Route::prefix('users/{user}')->group(function () {
        Route::prefix('carts')->group(function () {
            Route::post('add', [CartsController::class, 'add'])
                ->name('carts.add');
        });
        Route::resource('carts', CartsController::class)
            ->only(['index', 'destroy']);
    });
});


Route::get('/component-test1', [ComponentTestController::class, 'showComponent1']);
Route::get('/component-test2', [ComponentTestController::class, 'showComponent2']);
Route::get('/servicecontainertest', [LifeCycleTestController::class, 'showServiceContainerTest']);
Route::get('/serviceprovidertest', [LifeCycleTestController::class, 'showServiceProviderTest']);


require __DIR__ . '/auth.php';
