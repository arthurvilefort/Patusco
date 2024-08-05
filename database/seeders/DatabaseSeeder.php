<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Atendente',
                'email' => 'atendente@example.com',
                'password' => Hash::make('12345678'), 
                'level' => 1,
            ],
            [
                'name' => 'Doctor',
                'email' => 'doctor@example.com',
                'password' => Hash::make('12345678'), 
                'level' => 2,
            ],
            [
                'name' => 'Client',
                'email' => 'client@example.com',
                'password' => Hash::make('12345678'), 
                'level' => 0,
            ],
        ]);

        DB::table('pets')->insert([
            [
                'nome' => 'Rex',
                'tipo' => 0, 
                'data_nascimento' => '2020-01-01',
                'proprietario' => 3, 
            ],
            [
                'nome' => 'Mimi',
                'tipo' => 1, 
                'data_nascimento' => '2019-05-15',
                'proprietario' => 3, 
            ],
        ]);

        DB::table('consultas')->insert([
            [
                'usuario_id' => 3, 
                'pet_id' => 1, 
                'sintomas' => 'Coughing',
                'data_atendimento' => '2024-01-20',
                'turno' => 0,
                'medico_id' => 2, 
                'status' => 0,
                'obs' => 'Needs a check-up',
            ],
            [
                'usuario_id' => 3, 
                'pet_id' => 2, 
                'sintomas' => 'Lethargy',
                'data_atendimento' => '2024-01-21',
                'turno' => 1,
                'medico_id' => 2, 
                'status' => 0,
                'obs' => 'Possible flu',
            ],
        ]);
    }
}
