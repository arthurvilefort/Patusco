<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMedicos()
    {
        $medicos = User::where('level', 2)->get(['id', 'name']); // Certifique-se de obter os campos corretos
        return response()->json($medicos);
    }

}
