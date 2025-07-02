<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tarefas para popular o banco
        Task::create([
            'name' => 'Completar documentação do projeto',
            'description' => 'Finalizar a escrita do arquivo README abrangente com instruções de instalação e uso',
            'due_date' => Carbon::now()->addDays(3),
            'completed' => false,
        ]);

        Task::create([
            'name' => 'Corrigir bug de autenticação da API',
            'description' => 'Resolver o erro de autenticação no endpoint de atualização de tarefas que impede usuários de modificar tarefas',
            'due_date' => Carbon::now()->addDays(1),
            'completed' => true,
        ]);

        Task::create([
            'name' => 'Adicionar testes unitários',
            'description' => 'Criar testes unitários para as classes TaskService e TaskController',
            'due_date' => Carbon::now()->addDays(5),
            'completed' => false,
        ]);

        Task::create([
            'name' => 'Configurar pipeline CI/CD',
            'description' => 'Configurar pipeline automatizado de testes e deploy usando GitHub Actions',
            'due_date' => Carbon::now()->addDays(7),
            'completed' => false,
        ]);

        Task::create([
            'name' => 'Otimização do banco de dados',
            'description' => 'Adicionar índices e otimizar consultas do banco para melhor performance',
            'due_date' => Carbon::now()->addDays(4),
            'completed' => true,
        ]);

        Task::create([
            'name' => 'Melhorias na interface do usuário',
            'description' => 'Aprimorar a interface do usuário com melhor estilo',
            'due_date' => Carbon::now()->addDays(6),
            'completed' => false,
        ]);
    }
}
