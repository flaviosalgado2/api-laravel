<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClienteApiController;
use App\Http\Controllers\Api\DocumentoApiController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::get('clientes', [ClienteApiController::class, 'index']);
Route::get('clientes/{id}/documento', [ClienteApiController::class, 'documento']);
Route::apiResource('clientes', ClienteApiController::class);
Route::get('documento/{id}/cliente', [DocumentoApiController::class, 'cliente']);
Route::apiResource('documento', DocumentoApiController::class);
