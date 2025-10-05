<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Task::updateOrCreate(
            ['title' => 'Task 1'],
            [
                'description' => 'This is Test Description 1',
                'status' => 'pending', 
                'priority' => 'normal',
                'due_date' => Carbon::now()->addDays(rand(3, 15))->format('Y-m-d'),
                'assigned_to' => 2,
                'created_by' => 1
            ]
        );

        Task::updateOrCreate(
            ['title' => 'Task 2'],
            [
                'description' => 'This is Test Description 2',
                'status' => 'pending', 
                'priority' => 'normal',
                'due_date' => Carbon::now()->addDays(rand(3, 15))->format('Y-m-d'),
                'assigned_to' => 2,
                'created_by' => 1
            ]
        );

        Task::updateOrCreate(
            ['title' => 'Task 3'],
            [
                'description' => 'This is Test Description 3',
                'status' => 'pending', 
                'priority' => 'normal',
                'due_date' => Carbon::now()->addDays(rand(3, 15))->format('Y-m-d'),
                'assigned_to' => 2,
                'created_by' => 1
            ]
        );

        Task::updateOrCreate(
            ['title' => 'Task 4'],
            [
                'description' => 'This is Test Description 4',
                'status' => 'pending', 
                'priority' => 'normal',
                'due_date' => Carbon::now()->addDays(rand(3, 15))->format('Y-m-d'),
                'assigned_to' => 3,
                'created_by' => 1
            ]
        );

        Task::updateOrCreate(
            ['title' => 'Task 5'],
            [
                'description' => 'This is Test Description 5',
                'status' => 'pending', 
                'priority' => 'normal',
                'due_date' => Carbon::now()->addDays(rand(3, 15))->format('Y-m-d'),
                'assigned_to' => 3,
                'created_by' => 1
            ]
        );

        Task::updateOrCreate(
            ['title' => 'Task 6'],
            [
                'description' => 'This is Test Description 6',
                'status' => 'pending', 
                'priority' => 'normal',
                'due_date' => Carbon::now()->addDays(rand(3, 15))->format('Y-m-d'),
                'assigned_to' => 3,
                'created_by' => 1
            ]
        );
    }
}
