<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Categorias;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Categorias::all();
    }

    public function store(Request $request)
    {
        if (!isset($request->name)) {
            return response([
                "message" => "O campo 'name' é obrigatório!"
            ], 400);
        }

        if (Categorias::where('name', $request->name)->exists()) {
            return response([
                "message" => "Categoria já existe!"
            ], 409);
        }

        Categorias::create([
            "name" => $request->name,
        ]);

        return response([
            "message" => "Categoria criada com sucesso!"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $categoria = Categorias::findOrFail($id);
        } catch (\Throwable $th) {
            if ($th instanceof ModelNotFoundException) {
                return response([
                    "message" => "Produto não encontrado!"
                ], 404);
            }
            else {
                print($th);
                return response([
                    "message" => "Ocorreu um erro inesperado!"
                ], 500);
            }
        }
        return $categoria;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorias $categorias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $categoria = Categorias::findOrFail($id);
        } catch (\Throwable $th) {
            if ($th instanceof ModelNotFoundException) {
                return response([
                    "message" => "Categoria não encontrada!"
                ], 404);
            }
            else {
                print($th);
                return response([
                    "message" => "Ocorreu um erro inesperado!"
                ], 500);
            }
        }

        $categoria->update([
            "name" => $request->name
            
        ]);

        return response([
            "message" => "Categoria atualizada com sucesso!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
         try {
            $categoria = Categorias::findOrFail($id);
        } catch (\Throwable $th) {
            if ($th instanceof ModelNotFoundException) {
                return response([
                    "message" => "Categoria não encontrada!"
                ], 404);
            }
            else {
                print($th);
                return response([
                    "message" => "Ocorreu um erro inesperado!"
                ], 500);
            }
        }

        $categoria->delete();

        return response([
            "message" => "Categoria deletada com sucesso!"
        ], 200);
    }
}
