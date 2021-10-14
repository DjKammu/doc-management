<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',[App\Http\Controllers\API\LoginController::class,'login']);

Route::middleware('auth:api')->group( function() {
  
  Route::get('/user', function (Request $request) {
	    return $request->user();
	});

   Route::get('/properties',[App\Http\Controllers\API\PropertyController::class,'index']);
   Route::get('/documents',[App\Http\Controllers\API\DocumentController::class,'index']);
   Route::apiResource('document-types', App\Http\Controllers\API\DocumentTypeController::class);

});


Route::fallback(function () {
    return response()->json(['message' => 'Not Found!'], 404);
});