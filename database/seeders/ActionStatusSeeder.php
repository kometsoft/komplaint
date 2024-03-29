<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('action_statuses')->insert([
            ['name' => 'Pending', 'class' => 'bg-danger'],
            ['name' => 'In Progress', 'class' => 'bg-warning'],
            ['name' => 'Completed', 'class' => 'bg-success'],
        ]);
    }
}
