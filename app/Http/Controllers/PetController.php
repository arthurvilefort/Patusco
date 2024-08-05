<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;


class PetController extends Controller
{
    public function index()
    {
        try {
            $pets = Pet::all();
            return response()->json($pets);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|integer',
            'data_nascimento' => 'required|date',
        ]);

        try {
            $pet = new Pet();
            $pet->nome = $request->nome;
            $pet->tipo = $request->tipo;
            $pet->data_nascimento = $request->data_nascimento;
            $pet->proprietario = $request->user()->id;
            $pet->save();

            return response()->json($pet, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|integer',
            'data_nascimento' => 'required|date',
        ]);

        try {
            $pet = Pet::findOrFail($id);
            $pet->nome = $request->nome;
            $pet->tipo = $request->tipo;
            $pet->data_nascimento = $request->data_nascimento;
            $pet->save();

            return response()->json(['message' => 'Pet atualizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
