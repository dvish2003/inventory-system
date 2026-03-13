
<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CupboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PlaceController;
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

    //place route
    Route::post('/place/save', [PlaceController::class, 'savePlace']);
    Route::get('/place/getAll', [PlaceController::class, 'getAllPlaces']);
    Route::post('/place/update', [PlaceController::class, 'updatePlace']);
    Route::post('/place/delete', [PlaceController::class, 'deletePlace']);


    //inventory Route
     Route::post('/inventory/save', [InventoryController::class, 'saveInventoryItem']);
    Route::get('/inventory/getAll', [InventoryController::class, 'getAllInventoryItems']);
    Route::post('/inventory/update', [InventoryController::class, 'updateInventoryItem']);
    Route::post('/inventory/delete', [InventoryController::class, 'deleteItem']);


    //borrowing Route
    Route::post('/borrowing/save', [BorrowingController::class, 'saveBorrowing']);
Route::get('/borrowing/getAll', [BorrowingController::class, 'getAllBorrowings']);
Route::post('/borrowing/update', [BorrowingController::class, 'updateBorrowing']);
Route::post('/borrowing/delete', [BorrowingController::class, 'deleteBorrowing']);
    });
