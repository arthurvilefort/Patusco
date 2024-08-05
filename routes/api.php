<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ConsultaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/example', [HomeController::class, 'index']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/showpets', [PetController::class, 'index']);   
    Route::post('/pets', [PetController::class, 'store']);
    Route::put('/pets/{id}', [PetController::class, 'update']);
    Route::post('/agendamentos', [ConsultaController::class, 'store']);
    Route::get('/consultas', [ConsultaController::class, 'index']);
    Route::put('/consultas/{id}', [ConsultaController::class, 'update']);
    Route::get('/getMedicos', [HomeController::class, 'getMedicos']);
    Route::get('/medicos', [HomeController::class, 'getMedicos']);
    Route::get('/fechados/cliente', [ConsultaController::class, 'fechadoscliente']);
    Route::put('/fechados/cliente/{id}', [ConsultaController::class, 'update']);
    Route::get('/fechados/medico', [ConsultaController::class, 'fechadosmedico']);
    Route::put('/fechados/medico{id}', [ConsultaController::class, 'update']);
    Route::get('/fechados/rec', [ConsultaController::class, 'fechadosrec']);
    Route::put('/fechados/rec/{id}', [ConsultaController::class, 'update']);
    Route::get('/abertos/atribuidos', [ConsultaController::class, 'abertoatribuidos']);
    Route::put('/abertos/atribuidos/{id}', [ConsultaController::class, 'update']);
    Route::get('/abertos/rec', [ConsultaController::class, 'abertosrec']);
    Route::put('/abertos/rec/{id}', [ConsultaController::class, 'update']);
    Route::get('/abertos/medico', [ConsultaController::class, 'abertosmedico']);
    Route::put('/abertos/medico/{id}', [ConsultaController::class, 'update']);
    Route::delete('/consultas/{id}', [ConsultaController::class, 'destroy']);

    
});