<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('items',[ItemController::class,'items']);
Route::post('create',[ItemController::class,'create']);
Route::put('update',[ItemController::class,'update']);
Route::delete('delete',[ItemController::class,'delete']);
