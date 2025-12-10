<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tab;

class TabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tab::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cliente = $request->input('cliente');

        if (!$cliente) {
            return response()->json(['message' => 'O campo cliente é obrigatório.'], 400);
        }

        if (Tab::where('cliente', $cliente)->exists()) {
            return response()->json(['message' => 'Já existe uma tab para este cliente.'], 409);
        }

        $tab = Tab::create([
            'cliente' => $cliente,
            'total' => 0,
            'is_open' => true
        ]);

        return response()->json($tab, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tab $tab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tab $tab)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tab $tab)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tab $tab)
    {
        //
    }
}
