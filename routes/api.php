<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClienteApiController;
use App\Http\Controllers\Api\DocumentoApiController;
use App\Http\Controllers\Api\FilmeApiController;
use App\Http\Controllers\Api\TelefoneApiController;
use App\Http\Controllers\Auth\AuthController;

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

//Route::get('clientes', [ClienteApiController::class, 'index']);,
Route::post('auth/login', [AuthController::class, 'login']);
Route::get('auth/me', [AuthController::class, 'getAuthenticatedUser']);
Route::middleware(['apiJWT'])->group(function () {
    /** Informações do usuário logado */
    Route::get('auth/me', [AuthController::class, 'me']);
    /** Encerra o acesso */
    Route::get('auth/logout', [AuthController::class, 'logout']);
    /** Atualiza o token */
    Route::get('auth/refresh', [AuthController::class, 'refresh']);
    /** Listagem dos usuarios cadastrados, este rota serve de teste para verificar a proteção feita pelo jwt */
    Route::get('/users', [UserController::class, 'index']);
    /*Daqui para baixo você pode ir adiciondo todas as rotas que deverão estar protegidas em sua API*/
});

Route::get('clientes/{id}/filmes-alugados', [ClienteApiController::class, 'alugados']);
Route::get('clientes/{id}/documento', [ClienteApiController::class, 'documento']);
Route::get('clientes/{id}/telefone', [ClienteApiController::class, 'telefone']);
Route::apiResource('clientes', ClienteApiController::class);

Route::get('documento/{id}/cliente', [DocumentoApiController::class, 'cliente']);
Route::apiResource('documento', DocumentoApiController::class);

Route::get('telefone/{id}/cliente', [TelefoneApiController::class, 'cliente']);
Route::apiResource('telefone', TelefoneApiController::class);

Route::apiResource('filme', FilmeApiController::class);
