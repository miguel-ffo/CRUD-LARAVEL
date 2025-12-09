<?php

namespace App\Http\Controllers;
use App\Models\Produtos;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $query = Produtos::with('category');

        if ($req->itens) {
            $query->limit(intval($req->itens));
        }

        return $query->get();
    }

    

    public function store(Request $request)
    {
        if ($request->name === null || $request->price === null || $request->category_id === null) {
            return response([
                "message" => "Os campos 'name', 'price' e 'category_id' são obrigatórios!"
            ], 400);
        }
        
        if ($request->category_id) {
            $categoriaExists = \App\Models\Categorias::find($request->category_id);
            if (!$categoriaExists) {
                return response([
                    "message" => "Categoria não encontrada!"
                ], 404);
            }
        }
        if ($request->stock_quantity !== null && $request->stock_quantity < 0) {
            return response([
                "message" => "A quantidade em estoque não pode ser negativa!"
            ], 400);
        }

        Produtos::create([
            "name" => $request->name,
            "price" => $request->price,
            "category_id" => $request->category_id,
            "stock_quantity" => $request->stock_quantity
        ]);

        return response([
            "message" => "Produto criado com sucesso!"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $produto = Produtos::with('category')->findOrFail($id);
        } catch (\Throwable $th) {
            if ($th instanceof ModelNotFoundException) {
                return response([
                    "message" => "Produto não encontrado!"
                ], 404);
            }

            return response([
                "message" => "Ocorreu um erro inesperado!"
            ], 500);
        }

        return $produto;
    }


    public function getByCategory(int $category_id, Request $req)
    {
        try {
            $categoriaExists = \App\Models\Categorias::findOrFail($category_id);
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

        $itens = intval($req->itens ?? 0);

        if ($itens !== 0) {
            $produtos = Produtos::where('category_id', $category_id)->limit($itens)->get();
        }
        else {
            $produtos = Produtos::where('category_id', $category_id)->get();
        }
        return $produtos;
    }

    /**
     * Show the form for editing the specified resource.
    */
   
    public function update(Request $request, string $id)
    {
        try {
            $produto = Produtos::findOrFail($id);
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

        if ($request->name === null || $request->price === null || $request->category_id === null) {
            return response([
                "message" => "Os campos 'name', 'price' e 'category_id' são obrigatórios!"
            ], 400);
        }

        if ($request->category_id) {
            $categoriaExists = \App\Models\Categorias::find($request->category_id);
            if (!$categoriaExists) {
                return response([
                    "message" => "Categoria não encontrada!"
                ], 404);
            }
        }

        if ($request->stock_quantity !== null && $request->stock_quantity < 0) {
            return response([
                "message" => "A quantidade em estoque não pode ser negativa!"
            ], 400);
        }


        $produto->update([
            "name" => $request->name,
            "price" => $request->price,
            "category_id" => $request->category_id,
            "stock_quantity" => $request->stock_quantity
        ]);

        return response([
            "message" => "Produto atualizado com sucesso!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $produto = Produtos::findOrFail($id);
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

        $produto->delete();

        return response([
            "message" => "Produto deletado com sucesso!"
        ], 200);
    }

    public function sell (Request $req ,int $id)
    {
        try {
            $produto = Produtos::findOrFail($id);
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
        $quantity = intval($req->quantity);

        if ($quantity <= 0) {
            return response([
                "message" => "A quantidade para venda deve ser maior que zero!"
            ], 400);
        }

        if ($produto->stock_quantity < $quantity) {
            return response([
                "message" => "Quantidade em estoque insuficiente!",
                "stock_quantity" => $produto->stock_quantity
            ], 400);
        }

        $produto->update([
            "stock_quantity" => $produto->stock_quantity - $quantity
        ]);

        return response([
            "message" => "Produto vendido com sucesso!",
            "resume" => [
                "quantity_sold" => $quantity,
                "total_price" => $quantity * $produto->price,
                "stock_quantity" => $produto->stock_quantity
            ],

        ], 200);
    }

    public function restock (Request $req ,int $id)
    {
        try {
            $produto = Produtos::findOrFail($id);
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

        $quantity = intval($req->quantity);

        if ($quantity <= 0) {
            return response([
                "message" => "A quantidade para reposição deve ser maior que zero!"
            ], 400);
        }

        $produto->update([
            "stock_quantity" => $produto->stock_quantity + $quantity
        ]);

        return response([
            "message" => "Produto reabastecido com sucesso!",
            "resume" => [
                "quantity_restocked" => $quantity,
                "stock_quantity" => $produto->stock_quantity
            ],
        ], 200);
    }
}
