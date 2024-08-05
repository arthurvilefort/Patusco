<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed users table
        DB::table('users')->insert([
            [
                'name' => 'Ana',
                'email' => 'ana@ana.com',
                'password' => Hash::make('12345678'), 
                'level' => 1,
            ],
            [
                'name' => 'Dr. Jorge',
                'email' => 'jorge@jorge.com',
                'password' => Hash::make('12345678'), 
                'level' => 2,
            ],
            [
                'name' => 'Pedro',
                'email' => 'pedro@pedro.com',
                'password' => Hash::make('12345678'), 
                'level' => 0,
            ],
            [
                'name' => 'Maria',
                'email' => 'maria@maria.com',
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
            [
                'nome' => 'Zeus',
                'tipo' => 0, 
                'data_nascimento' => '2018-03-21',
                'proprietario' => 4, 
            ],
            [
                'nome' => 'Jorge',
                'tipo' => 1, 
                'data_nascimento' => '2021-06-13',
                'proprietario' => 4, 
            ],
            [
                'nome' => 'Louro',
                'tipo' => 2, 
                'data_nascimento' => '2022-09-11',
                'proprietario' => 4, 
            ],
            
            ['nome' => 'Buddy', 'tipo' => 0, 'data_nascimento' => '2020-07-08', 'proprietario' => 3],
            ['nome' => 'Luna', 'tipo' => 1, 'data_nascimento' => '2019-12-01', 'proprietario' => 3],
            ['nome' => 'Max', 'tipo' => 0, 'data_nascimento' => '2018-04-21', 'proprietario' => 4],
            ['nome' => 'Bella', 'tipo' => 1, 'data_nascimento' => '2021-10-10', 'proprietario' => 4],
            ['nome' => 'Charlie', 'tipo' => 0, 'data_nascimento' => '2022-01-11', 'proprietario' => 3],
            ['nome' => 'Lucy', 'tipo' => 1, 'data_nascimento' => '2017-02-14', 'proprietario' => 4],
            ['nome' => 'Daisy', 'tipo' => 2, 'data_nascimento' => '2016-05-25', 'proprietario' => 3],
            ['nome' => 'Rocky', 'tipo' => 0, 'data_nascimento' => '2015-08-30', 'proprietario' => 3],
            ['nome' => 'Molly', 'tipo' => 1, 'data_nascimento' => '2020-11-12', 'proprietario' => 4],
            ['nome' => 'Coco', 'tipo' => 2, 'data_nascimento' => '2019-09-15', 'proprietario' => 3],
        ]);

        $consultas = [
            [
                'usuario_id' => 3,
                'pet_id' => 1,
                'sintomas' => 'Tosse',
                'data_atendimento' => '2024-01-20',
                'turno' => 0,
                'medico_id' => null,
                'status' => 0,
                'obs' => null,
            ],
            [
                'usuario_id' => 3,
                'pet_id' => 2,
                'sintomas' => 'Letargia',
                'data_atendimento' => '2024-01-21',
                'turno' => 1,
                'medico_id' => 2,
                'status' => 0,
                'obs' => 'Possível gripe',
            ],
            [
                'usuario_id' => 4,
                'pet_id' => 3,
                'sintomas' => 'Febre',
                'data_atendimento' => '2024-02-15',
                'turno' => 0,
                'medico_id' => null,
                'status' => 0,
                'obs' => null,
            ],
            [
                'usuario_id' => 4,
                'pet_id' => 4,
                'sintomas' => 'Vômito',
                'data_atendimento' => '2024-03-10',
                'turno' => 1,
                'medico_id' => 2,
                'status' => 1,
                'obs' => 'Medicação administrada',
            ],
            [
                'usuario_id' => 4,
                'pet_id' => 5,
                'sintomas' => 'Diarréia',
                'data_atendimento' => '2024-04-01',
                'turno' => 0,
                'medico_id' => 2,
                'status' => 1,
                'obs' => 'Recomendação de dieta especial',
            ],
            ['usuario_id' => 3, 'pet_id' => 6, 'sintomas' => 'Perda de apetite', 'data_atendimento' => '2024-02-01', 'turno' => 1, 'medico_id' => null, 'status' => 0, 'obs' => null],
            ['usuario_id' => 3, 'pet_id' => 7, 'sintomas' => 'Infecção ocular', 'data_atendimento' => '2024-03-05', 'turno' => 0, 'medico_id' => 2, 'status' => 0, 'obs' => 'Antibiótico prescrito'],
            ['usuario_id' => 4, 'pet_id' => 8, 'sintomas' => 'Tosse', 'data_atendimento' => '2024-04-15', 'turno' => 1, 'medico_id' => null, 'status' => 1, 'obs' => null],
            ['usuario_id' => 4, 'pet_id' => 9, 'sintomas' => 'Coceira', 'data_atendimento' => '2024-05-20', 'turno' => 0, 'medico_id' => 2, 'status' => 1, 'obs' => 'Alergia identificada'],
            ['usuario_id' => 3, 'pet_id' => 10, 'sintomas' => 'Dores nas articulações', 'data_atendimento' => '2024-06-10', 'turno' => 1, 'medico_id' => 2, 'status' => 0, 'obs' => 'Fisioterapia recomendada'],
            ['usuario_id' => 4, 'pet_id' => 11, 'sintomas' => 'Anemia', 'data_atendimento' => '2024-07-05', 'turno' => 0, 'medico_id' => null, 'status' => 0, 'obs' => null],
            ['usuario_id' => 3, 'pet_id' => 12, 'sintomas' => 'Febre', 'data_atendimento' => '2024-08-02', 'turno' => 1, 'medico_id' => 2, 'status' => 1, 'obs' => 'Antitérmico prescrito'],
            ['usuario_id' => 4, 'pet_id' => 13, 'sintomas' => 'Diarreia', 'data_atendimento' => '2024-09-18', 'turno' => 0, 'medico_id' => 2, 'status' => 1, 'obs' => 'Hidratação e dieta especial'],
            ['usuario_id' => 3, 'pet_id' => 14, 'sintomas' => 'Perda de peso', 'data_atendimento' => '2024-10-10', 'turno' => 1, 'medico_id' => null, 'status' => 0, 'obs' => null],
        ];

        DB::table('consultas')->insert($consultas);
    }
}
