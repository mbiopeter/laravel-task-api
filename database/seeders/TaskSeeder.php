<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run()
    {
        Task::create([
            'title' => 'API Development',
            'due_date' => now()->addDays(1),
            'priority' => 'high',
            'status' => 'pending'
        ]);

        Task::create([
            'title' => 'Testing API',
            'due_date' => now()->addDays(2),
            'priority' => 'medium',
            'status' => 'in_progress'
        ]);

        Task::create([
            'title' => 'Deploy App',
            'due_date' => now()->addDays(3),
            'priority' => 'low',
            'status' => 'done'
        ]);
    }
}
