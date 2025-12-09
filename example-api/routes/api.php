<?php
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\CategoriasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/produtos/{qnt?}', [ProdutosController::class, 'index']);
Route::post('/produtos', [ProdutosController::class, 'store']);
Route::get('/produtos/{id}', [ProdutosController::class, 'show']);
Route::get('/produtos/category/{category_id}/{qnt?}', [ProdutosController::class, 'getByCategory']);
Route::patch('/produtos/{id}', [ProdutosController::class, 'update']);
Route::delete('/produtos/{id}', [ProdutosController::class, 'destroy']);

Route::get('/categorias', [CategoriasController::class, 'index']);
Route::post('/categorias', [CategoriasController::class, 'store']);
Route::get('/categorias/{id}', [CategoriasController::class, 'show']);
Route::patch('/categorias/{id}', [CategoriasController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriasController::class, 'destroy']);
