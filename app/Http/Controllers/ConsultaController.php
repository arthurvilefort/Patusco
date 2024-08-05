<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Importação do Log

class ConsultaController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $consultas = Consulta::with(['usuario', 'pet'])
            ->where('usuario_id', $userId)
            ->where('status', 0) 
            ->get()
            ->map(function ($consulta) {
                return [
                    'id' => $consulta->id,
                    'usuario_nome' => $consulta->usuario->name,
                    'pet_nome' => $consulta->pet->nome,
                    'tipo_pet' => $this->getTipoPet($consulta->pet->tipo),
                    'sintomas' => $consulta->sintomas,
                    'data_atendimento' => $consulta->data_atendimento,
                    'turno' => $consulta->turno == 0 ? 'Manhã' : 'Tarde',
                    'medico_nome' => $consulta->medico ? $consulta->medico->name : null,
                    'obs' => $consulta->obs,
                    'created_at' => $consulta->created_at,
                    'updated_at' => $consulta->updated_at,
                    'status' => $consulta->status, 
                ];
            });

        return response()->json($consultas);
    }

    private function getTipoPet($tipo)
    {
        $tipoMap = [
            0 => 'Cão',
            1 => 'Gato',
            2 => 'Ave',
            3 => 'Roedor',
            4 => 'Outro',
        ];
        return $tipoMap[$tipo] ?? 'Desconhecido';
    }

    public function store(Request $request)
    {
        // Debugging: Log the request data
        Log::info('Request Data:', $request->all());

        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'sintomas' => 'required|string|max:255',
            'data_atendimento' => 'required|date',
            'turno' => 'required|boolean',
        ]);

        $consulta = new Consulta();
        $consulta->usuario_id = Auth::id();
        $consulta->pet_id = $validated['pet_id'];
        $consulta->sintomas = $validated['sintomas'];
        $consulta->data_atendimento = $validated['data_atendimento'];
        $consulta->turno = $validated['turno'];
        $consulta->status = 0; // Status inicial
        $consulta->save();

        return response()->json(['message' => 'Agendamento criado com sucesso'], 201);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'sintomas' => 'required|string|max:255',
            'data_atendimento' => 'required|date',
            'turno' => 'required|boolean',
            'obs' => 'nullable|string|max:255',
            'medico_id' => 'nullable|exists:users,id',
            'status' => 'required|boolean',

        ]);

        $consulta = Consulta::findOrFail($id);
        $consulta->sintomas = $validated['sintomas'];
        $consulta->data_atendimento = $validated['data_atendimento'];
        $consulta->turno = $validated['turno'];
        $consulta->obs = $validated['obs'];
        $consulta->medico_id = $validated['medico_id']; 
        $consulta->status = $validated['status']; 
        $consulta->save();

        return response()->json(['message' => 'Consulta atualizada com sucesso'], 200);
    }
    
    public function destroy($id)
{
    $consulta = Consulta::findOrFail($id);
    $consulta->delete();

    return response()->json(['message' => 'Consulta excluída com sucesso'], 200);
}

    public function fechadoscliente()
    {
        $userId = Auth::id();
        $consultas = Consulta::with(['usuario', 'pet'])
            ->where('usuario_id', $userId)
            ->where('status', 1) 
            ->get()
            ->map(function ($consulta) {
                return [
                    'id' => $consulta->id,
                    'usuario_nome' => $consulta->usuario->name,
                    'pet_nome' => $consulta->pet->nome,
                    'tipo_pet' => $this->getTipoPet($consulta->pet->tipo),
                    'sintomas' => $consulta->sintomas,
                    'data_atendimento' => $consulta->data_atendimento,
                    'turno' => $consulta->turno == 0 ? 'Manhã' : 'Tarde',
                    'medico_nome' => $consulta->medico ? $consulta->medico->name : null,
                    'obs' => $consulta->obs,
                    'created_at' => $consulta->created_at,
                    'updated_at' => $consulta->updated_at,
                    'status' => $consulta->status, 
                ];
            });

        return response()->json($consultas);
    }
    public function fechadosmedico()
    {
        $userId = Auth::id();
        $consultas = Consulta::with(['usuario', 'pet'])
            ->where('medico_id', $userId)
            ->where('status', 1) 
            ->get()
            ->map(function ($consulta) {
                return [
                    'id' => $consulta->id,
                    'usuario_nome' => $consulta->usuario->name,
                    'pet_nome' => $consulta->pet->nome,
                    'tipo_pet' => $this->getTipoPet($consulta->pet->tipo),
                    'sintomas' => $consulta->sintomas,
                    'data_atendimento' => $consulta->data_atendimento,
                    'turno' => $consulta->turno == 0 ? 'Manhã' : 'Tarde',
                    'medico_nome' => $consulta->medico ? $consulta->medico->name : null,
                    'obs' => $consulta->obs,
                    'created_at' => $consulta->created_at,
                    'updated_at' => $consulta->updated_at,
                    'status' => $consulta->status, 
                    'medico_id' => $consulta->medico_id,

                ];
            });

        return response()->json($consultas);
    }

    public function fechadosrec()
    {
        $userId = Auth::id();
        $consultas = Consulta::with(['usuario', 'pet'])
            ->where('status', 1) 
            ->get()
            ->map(function ($consulta) {
                return [
                    'id' => $consulta->id,
                    'usuario_nome' => $consulta->usuario->name,
                    'pet_nome' => $consulta->pet->nome,
                    'tipo_pet' => $this->getTipoPet($consulta->pet->tipo),
                    'sintomas' => $consulta->sintomas,
                    'data_atendimento' => $consulta->data_atendimento,
                    'turno' => $consulta->turno == 0 ? 'Manhã' : 'Tarde',
                    'medico_nome' => $consulta->medico ? $consulta->medico->name : null,
                    'obs' => $consulta->obs,
                    'created_at' => $consulta->created_at,
                    'updated_at' => $consulta->updated_at,
                    'status' => $consulta->status, 
                ];
            });

        return response()->json($consultas);
    }
    public function abertoatribuidos()
    {
        $userId = Auth::id();
        $consultas = Consulta::with(['usuario', 'pet'])
            ->where('status', 0) 
            ->whereNotNull('medico_id') 
            ->get()
            ->map(function ($consulta) {
                return [
                    'id' => $consulta->id,
                    'usuario_nome' => $consulta->usuario->name,
                    'pet_nome' => $consulta->pet->nome,
                    'tipo_pet' => $this->getTipoPet($consulta->pet->tipo),
                    'sintomas' => $consulta->sintomas,
                    'data_atendimento' => $consulta->data_atendimento,
                    'turno' => $consulta->turno == 0 ? 'Manhã' : 'Tarde',
                    'medico_nome' => $consulta->medico ? $consulta->medico->name : null,
                    'obs' => $consulta->obs,
                    'created_at' => $consulta->created_at,
                    'updated_at' => $consulta->updated_at,
                    'status' => $consulta->status, 
                    'medico_id' => $consulta->medico_id,
                ];
            });

        return response()->json($consultas);
    }

    public function abertosrec()
    {
        $userId = Auth::id();
        $consultas = Consulta::with(['usuario', 'pet'])
            ->where('status', 0) 
            ->whereNull('medico_id') 
            ->get()
            ->map(function ($consulta) {
                return [
                    'id' => $consulta->id,
                    'usuario_nome' => $consulta->usuario->name,
                    'pet_nome' => $consulta->pet->nome,
                    'tipo_pet' => $this->getTipoPet($consulta->pet->tipo),
                    'sintomas' => $consulta->sintomas,
                    'data_atendimento' => $consulta->data_atendimento,
                    'turno' => $consulta->turno == 0 ? 'Manhã' : 'Tarde',
                    'medico_nome' => $consulta->medico ? $consulta->medico->name : null,
                    'obs' => $consulta->obs,
                    'created_at' => $consulta->created_at,
                    'updated_at' => $consulta->updated_at,
                    'status' => $consulta->status, 
                    'medico_id' => $consulta->medico_id,
                ];
            });

        return response()->json($consultas);
    }

    public function abertosmedico()
    {
        $userId = Auth::id();
        $consultas = Consulta::with(['usuario', 'pet'])
            ->where('medico_id', $userId)
            ->where('status', 0) 
            ->get()
            ->map(function ($consulta) {
                return [
                    'id' => $consulta->id,
                    'usuario_nome' => $consulta->usuario->name,
                    'pet_nome' => $consulta->pet->nome,
                    'tipo_pet' => $this->getTipoPet($consulta->pet->tipo),
                    'sintomas' => $consulta->sintomas,
                    'data_atendimento' => $consulta->data_atendimento,
                    'turno' => $consulta->turno == 0 ? 'Manhã' : 'Tarde',
                    'medico_nome' => $consulta->medico ? $consulta->medico->name : null,
                    'obs' => $consulta->obs,
                    'created_at' => $consulta->created_at,
                    'updated_at' => $consulta->updated_at,
                    'status' => $consulta->status, 
                    'medico_id' => $consulta->medico_id,

                ];
            });

        return response()->json($consultas);
    }

}
