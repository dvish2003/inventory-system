
<?php

use App\Http\Controllers\CupboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//without check jwt token
Route::post('/user/loginUser', [UserController::class, 'loginUser']);


Route::middleware(['auth:api'])->group(function () {
    //user routing
    Route::post('/user/saveUser', [UserController::class, 'saveUser']);
    Route::get('/user/getAllUsers', [UserController::class, 'getAllUsers']);
    Route::post('/user/updateUser', [UserController::class, 'updateUser']);
    Route::post('/user/deleteUser', [UserController::class, 'deleteUser']);

    //cupboard route
    Route::post('/cupboard/save', [CupboardController::class, 'saveCupboard']);
    Route::get('/cupboard/getAll', [CupboardController::class, 'getAllCupboards']);
    Route::post('/cupboard/update', [CupboardController::class, 'updateCupboard']);
    Route::post('/cupboard/delete', [CupboardController::class, 'deleteCupboard']);

});
